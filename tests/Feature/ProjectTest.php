<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Client;
use Spatie\Permission\Models\Role;
use Database\Seeders\ProjectSeeder;
class ProjectTest extends TestCase
{
    public function setUp():void 
    {
        parent::setUp();
        $adminRole = Role::where('name', 'admin')->first();
        $this->adminUser = User::factory()->create()->assignRole($adminRole);
    }

    public function test_project_index_page_can_be_rendered(): void
    {
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.projects.index'))
                        ->assertViewIs('projects.index');

    }

    public function test_project_paginations_is_working(): Void
    {
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.projects.index'))
                        ->assertViewHas('projects')
                        ->assertStatus(200);
    }

    public function test_project_belongs_to_user_relationship_is_set(): Void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory(['user_id' => $user->id, 'client_id' => $client->id])->create();
        $this->assertInstanceOf(User::class, $project->user);
    }

    public function test_project_belongs_to_client_relationship_is_set(): Void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory(['user_id' => $user->id, 'client_id' => $client->id])->create();
        $this->assertInstanceOf(Client::class, $project->client);
    }

    public function test_create_new_project_page_is_working(): Void
    {
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.projects.create'))
                        ->assertViewIs('projects.create');
    }

    public function test_store_empty_form_throw_validation_error(): Void
    {
        $project = [
            'title' => '',
            'description' => '',
            'dateline' => '',
            'status' => '',
            'user_id' => '',
            'client_id' => ''
        ];

        $response = $this->actingAs($this->adminUser)
                        ->post(route('admin.projects.store', $project))
                        ->assertStatus(302);
    }

    public function test_can_create_new_project(): Void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = [
            'title' => 'test',
            'description' => 'test desc',
            'dateline' => '2023-01-01',
            'status' => \App\Enums\StatusEnum::Open,
            'user_id' => $user->id,
            'client_id' => $client->id
        ];

        $response = $this->actingAs($this->adminUser)
                    ->post(route('admin.projects.store', $project))
                    ->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', $project);
    }

    public function test_edit_page_is_working(): Void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory(['user_id' => $user->id, 'client_id' => $client->id])->create();
        $response = $this->actingAs($this->adminUser)
                    ->get(route('admin.projects.edit', $project))
                    ->assertViewIs('projects.edit');
    }

    public function test_can_update_project(): Void
    {
        $user = User::factory()->create();
        $client = CLient::factory()->create();
        
        $this->seed(ProjectSeeder::class);

        $projectUpdted = [
            'title' => 'updated test',
            'description' => 'updated test desc',
            'dateline' => '2023-02-02',
            'status' => 'open',
            'user_id' => $user->id,
            'client_id' => $client->id
        ];

        $project = Project::first();

        $response = $this->actingAs($this->adminUser)
                    ->put("/admin/projects/{$project->id}", $projectUpdted)
                    ->assertRedirect(route('admin.projects.index'))
                    ->assertStatus(302);

        $this->assertDatabaseHas('projects', $projectUpdted);
    }

    public function test_can_soft_delete_project(): Void
    {
        $project = Project::factory()->create();
        $project->delete();
        
        $this->assertSoftDeleted('projects', [
            'id' => $project->id,
        ]);
    }

    public function test_only_deleted_projects_listed_when_passing_view_deleted_param()
    {
        $project = Project::factory()->create();
        $project->delete();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.projects.index', ['view_deleted' => 'DeletedClient']))
                        ->assertSee($project->contact_email)
                        ->assertStatus(200);
    }

    public function test_can_force_delete_project(): Void
    {
        $project = Project::factory()->create();
        $project->delete();

        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.projects.force_delete', $project->id))
                        ->assertStatus(302);

        $this->assertDatabaseMissing('projects', ['title' => $project->title]);
    }

    public function test_can_restore_deleted_project(): Void
    {
        $project = Project::factory()->create();
        $project->delete();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.projects.restore', $project->id))
                        ->assertStatus(302);
        $this->assertDatabaseHas('projects', ['deleted_at' => null]);
    }

    public function test_can_restore_all_deleted_project(): Void
    {
        $project = Project::factory(10)->create();
        $project->each->delete();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.projects.restore.all'))
                        ->assertStatus(302);
        $this->assertDatabaseHas('projects', ['deleted_at' => null]);
    }

    public function test_can_view_single_project(): Void
    {
        $project = Project::factory()->create();
        $response = $this->actingAs($this->adminUser)
                    ->get(route('admin.projects.show', $project))
                    ->assertViewIs('projects.show')
                    ->assertStatus(200);
    }
}
