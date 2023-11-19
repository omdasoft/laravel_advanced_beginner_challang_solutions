<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Client;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Database\Seeders\ClientSeeder;
use App\Models\Project;

class ClientTest extends TestCase
{
    use RefreshDatabase;
    public function setUp():void 
    {
        parent::setUp();
        $adminRole = Role::where('name', 'admin')->first();
        $this->adminUser = User::factory()->create()->assignRole($adminRole);
    }

    public function test_client_index_page_is_working(): void
    {
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.clients.index'))
                        ->assertStatus(200);
    }

    public function test_client_list_is_paginated()
    {
        $this->seed(ClientSeeder::class);
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.clients.index'))
                        ->assertViewHas('clients')
                        ->assertStatus(200);

    }

    public function test_can_create_new_client()
    {
        $client = [
            'contact_name' => 'test name',
            'contact_email' => 'test@test.com',
            'contact_phone_number' => '09876543',
            'company_name' => 'test company name',
            'company_address' => 'test address name',
            'company_city' => 'test city',
            'contact_zip' => '1233',
            'company_vat' => 5
        ];

        $response = $this->actingAs($this->adminUser)
                        ->post(route('admin.clients.store', $client))
                        ->assertRedirect(route('admin.clients.index'))
                        ->assertStatus(302);
    }

    public function test_create_new_client_validation_is_working() 
    {
        $client = [
            'contact_name' => '',
            'contact_email' => 'test',
            'contact_phone_number' => '098',
            'company_name' => '',
            'company_address' => '',
            'company_city' => '',
            'contact_zip' => '',
            'company_vat' => 'jhhjjj'
        ];
        
        $response = $this->actingAs($this->adminUser)
                        ->post(route('admin.clients.store', $client))
                        ->assertStatus(302);
    }

    public function test_only_deleted_clients_listed_when_passing_view_deleted_param()
    {
        $client = Client::factory()->create();
        $client->delete();
        $this->seed(ClientSeeder::class);
        $clients = Client::get();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.clients.index', ['view_deleted' => 'DeletedClient']))
                        ->assertSee($client->email)
                        ->assertDontSee($clients)
                        ->assertStatus(200);
    }

    public function test_edit_client_page_is_working()
    {
        $client = Client::factory()->create();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.clients.edit', $client))
                        ->assertViewIs('clients.edit')
                        ->assertSee($client->email)
                        ->assertStatus(200);
    }

    public function test_can_update_client()
    {
        $clientUpdate = [
            'contact_name' => 'test name',
            'contact_email' => 'test@test.com',
            'contact_phone_number' => '09876543',
            'company_name' => 'test company name',
            'company_address' => 'test address name',
            'company_city' => 'test city',
            'contact_zip' => '1233',
            'company_vat' => 5
        ];

        $this->seed(ClientSeeder::class);

        $client = Client::first();
        $response = $this->actingAs($this->adminUser)
                        ->put("/admin/clients/{$client->id}", $clientUpdate)
                        ->assertRedirect(route('admin.clients.index'))
                        ->assertStatus(302);
    }

    public function test_can_force_delete_client()
    {
        $client = Client::factory()->create();
        $client->delete();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.clients.force_delete', $client->id))
                        ->assertStatus(302);
        $this->assertDatabaseMissing('clients', ['contact_email' => $client->contact_email]);
    }

    public function test_can_force_delete_all_deleted_clients()
    {
        $clients = Client::factory(10)->create();
        $clients->each->delete();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.clients.force_delete.all'))
                        ->assertStatus(302);

        $this->assertDatabaseCount('clients', 0);
    }

    public function test_can_restore_deleted_client()
    {
        $client = Client::factory()->create();
        $client->delete();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.clients.restore', $client->id))
                        ->assertStatus(302);
        $this->assertDatabaseHas('clients', ['contact_email' => $client->contact_email]);
    }

    public function test_can_restore_all_deleted_clients()
    {
        $clients = Client::factory(10)->create();
        $clients->each->delete();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.clients.restore.all'))
                        ->assertStatus(302);
        $this->assertDatabaseCount('clients', $clients->count());
    }

    public function test_client_has_many_project_relationship_is_set()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id
        ]);

        $this->assertTrue($client->projects->contains($project));
        $this->assertEquals(1, $client->projects->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $client->projects);
    }

}
