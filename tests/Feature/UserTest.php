<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\UserSeeder;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Client;
use App\Models\Task;
use Spatie\Permission\Models\Role;

class UserTest extends TestCase
{
    use RefreshDatabase;
    public function setUp():void 
    {
        parent::setUp();
        $adminRole = Role::where('name', 'admin')->first();
        $this->adminUser = User::factory()->create()->assignRole($adminRole);
    }
    public function test_users_index_page_can_be_rendered(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.users.index'))
            ->assertViewIs('users.index')
            ->assertStatus(200);
    }

    public function test_it_display_users_list_with_pagination()
    {
        $response = $this->actingAs($this->adminUser)
                    ->get(route('admin.users.index'))
                    ->assertViewHas('users');
    }

    public function test_can_soft_delete_a_user() 
    {
        $user = User::factory()->create();
        $user->delete();
        $this->assertSoftDeleted('users', [
            'id' => $user->id,
            'email' => $user->email
        ]);
    }

    public function test_user_roles_relationship_is_set() 
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test']);
        $user->assignRole($role);
        $this->assertTrue($user->roles->contains($role));
        $this->assertEquals(1, $user->roles->count());
    }

    public function test_only_deleted_users_are_displayed_in_index_page_when_passing_view_deleted_param() 
    {
        $testUser = User::factory()->create();
        $this->seed(UserSeeder::class);
        $testUser->delete();
        $view_deleted = true;
        $users = User::get();
        $response = $this->actingAs($this->adminUser)
                    ->get(route('admin.users.index', ['view_deleted' => $view_deleted]))
                    ->assertSee($testUser->email)
                    ->assertDontSee($users);

    }

    public function test_can_force_delete_a_user() 
    {
        $testUser = User::factory()->create();
        $this->seed(UserSeeder::class);
        $testUser->forceDelete();
        $view_deleted = true;
        $response = $this->actingAs($this->adminUser)
                    ->get(route('admin.users.index', ['view_deleted' => $view_deleted]))
                    ->assertDontSee($testUser->email);
        $this->assertDatabaseMissing('users', ['email' => $testUser->email]);
    }

    public function test_can_restore_deleted_user() 
    {
        $testUser = User::factory()->create();
        $testUser->delete();
        $response = $this->actingAs($this->adminUser)
                    ->get(route('admin.users.restore', $testUser->id))
                    ->assertStatus(302);
    }

    public function test_edit_user_page_is_working() 
    {
        $testUser = User::factory()->create();
        $updatedUser = [
            'first_name' => 'test first_name',
            'last_name' => 'test last_name',
            'email' => 'testUpdate@test.com',
            'phone_number' => '0912345678',
        ]; 
        $testUser->update($updatedUser);
        $response = $this->actingAs($this->adminUser)
                    ->get(route('admin.users.index'))
                    ->assertSee($updatedUser)
                    ->assertStatus(200);
    }

    public function test_can_create_new_user() 
    {
        $testRole = Role::create(['name' => 'test']);
        $user = [
            'first_name' => 'test f',
            'last_name' => 'test l',
            'email' => 'test@test.com',
            'phone_number' => '0098765432',
            'address' => 'test add',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => $testRole->id,
        ];

        $response = $this->actingAs($this->adminUser)
                    ->post(route('admin.users.store', $user))
                    ->assertRedirect(route('admin.users.index'))
                    ->assertStatus(302);
    }

    public function test_create_new_user_with_empty_record_throw_validation_error() 
    {
        $user = [
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'phone_number' => '',
            'address' => '',
            'password' => '',
            'password_confirmation' => '',
            'role' => '',
        ];

        $response = $this->actingAs($this->adminUser)
                    ->post(route('admin.users.store', $user))
                    ->assertStatus(302);
    }

    public function test_user_has_many_projects_relationship_is_set()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);
        $this->assertTrue($user->projects->contains($project));
        $this->assertEquals(1, $user->projects->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->projects);
    }

    public function test_user_has_many_tasks_relationship_is_set()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->create();
        $task = Task::factory()->create(
            [
                'user_id' => $user->id, 
                'client_id' => $client->id, 
                'project_id' => $project->id
            ]);
        
        $this->assertTrue($user->tasks->contains($task));
        $this->assertEquals(1, $user->tasks->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->tasks);
    }
}
