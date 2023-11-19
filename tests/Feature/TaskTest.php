<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Client;
use App\Models\Task;
use Spatie\Permission\Models\Role;
use Database\Seeders\TaskSeeder;

class TaskTest extends TestCase
{
    public function setUp():void 
    {
        parent::setUp();
        $adminRole = Role::where('name', 'admin')->first();
        $this->adminUser = User::factory()->create()->assignRole($adminRole);
    }

    public function test_tasks_index_page_can_be_rendered(): void
    {
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.tasks.index'))
                        ->assertViewIs('tasks.index');
    }

    public function test_task_pagination_is_working(): void
    {
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.tasks.index'))
                        ->assertViewHas('tasks')
                        ->assertStatus(200);
    }

    public function test_task_belongs_to_user_relationship_is_set(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $this->assertInstanceOf(User::class, $task->user);
    }

    public function test_task_belongs_to_client_relationship_is_set(): void
    {
        $client = Client::factory()->create();
        $task = Task::factory()->create(['client_id' => $client->id]);
        $this->assertInstanceOf(Client::class, $task->client);
    }

    public function test_task_belongs_to_project_relationship_is_set(): void
    {
        $project = Project::factory()->create();
        $task = Task::factory()->create(['project_id' => $project->id]);
        $this->assertInstanceOf(Project::class, $task->project);
    }

    public function test_create_new_task_page_can_be_rendered(): void
    {
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.tasks.create'))
                        ->assertViewIs('tasks.create')
                        ->assertStatus(200);
    }

    public function test_submit_empty_task_throw_validation_errors(): void 
    {
        $task = [
            'title' => '',
            'description' => '',
            'dateline' => '',
            'status' => '',
            'user_id' => '',
            'client_id' => '',
            'project_id' => ''
        ];
        
        $response = $this->actingAs($this->adminUser)
                        ->post(route('admin.tasks.store', $task))
                        ->assertStatus(302);
    }

    public function test_can_store_task(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->create();
        $task = [
            'title' => 'test title',
            'description' => 'test desc',
            'dateline' => '2023-05-31',
            'status' => \App\Enums\StatusEnum::Open,
            'user_id' => $user->id,
            'client_id' => $client->id,
            'project_id' => $project->id
        ];

        $response = $this->actingAs($this->adminUser)
                        ->post(route('admin.tasks.store', $task))
                        ->assertRedirectToRoute('admin.tasks.index')
                        ->assertStatus(302);
        $this->assertDatabaseHas('tasks', $task);
    }

    public function test_task_edit_page_can_be_rendered(): void
    {
        $task = Task::factory()->create();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.tasks.edit', $task))
                        ->assertViewIs('tasks.edit');
    }

    public function test_can_update_task(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->create();
        $task = Task::factory()->create();
        $data = [
            'title' => 'updated test title',
            'description' => 'updated test desc',
            'dateline' => '2023-06-1',
            'status' => 'open',
            'user_id' => $user->id,
            'client_id' => $client->id,
            'project_id' => $project->id
        ];

        $response = $this->actingAs($this->adminUser)
                        ->put("/admin/tasks/{$task->id}", $data)
                        ->assertRedirectToRoute('admin.tasks.index')
                        ->assertStatus(302);
        $this->assertDatabaseHas('tasks', $data);
    }

    public function test_can_soft_delete_a_taks(): void
    {
        $task = Task::factory()->create();
        $response = $this->actingAs($this->adminUser)
                        ->delete(route('admin.tasks.destroy', $task->id))
                        ->assertRedirectToRoute('admin.tasks.index')
                        ->assertStatus(302);

        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }

    public function test_only_deleted_tasks_listed_when_passing_view_deleted_param()
    {
        $task = Task::factory()->create();
        $task->delete();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.tasks.index', ['view_deleted' => 'DeletedClient']))
                        ->assertStatus(200);
    }

    public function test_can_force_delete_a_task(): void
    {
        $task = Task::factory()->create();
        $task->delete();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.tasks.force_delete', $task->id))
                        ->assertStatus(302);
        $this->assertDatabaseMissing('tasks', ['title' => $task->title]);
    }

    public function test_can_force_delete_all_deleted_tasks(): void
    {
        $this->seed(TaskSeeder::class);
        $tasks = Task::get()->each->delete();
    
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.tasks.force_delete.all'))
                        ->assertStatus(302);
        
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_can_restore_deleted_task(): void
    {
        $task = Task::factory()->create();
        $task->delete();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.tasks.restore', $task->id))
                        ->assertStatus(302);
        $this->assertDatabaseHas('tasks', ['deleted_at' => null]);
    }

    public function test_can_restore_all_deleted_tasks(): void
    {
        $tasks = Task::factory()->count(10)->create();
        $tasks->each->delete();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.tasks.restore.all'))
                        ->assertStatus(302);
        $this->assertDatabaseHas('tasks', ['deleted_at' => null]);
    }

    public function test_view_task_page_can_be_rendered(): void
    {
        $task = Task::factory()->create();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.tasks.show', $task))
                        ->assertViewIs('tasks.show')
                        ->assertStatus(200);
    }

}
