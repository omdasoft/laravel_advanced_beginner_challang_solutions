<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use Spatie\Permission\Models\Role;
class DashboardTest extends TestCase
{
    use RefreshDatabase;
    public function setUp():void 
    {
        parent::setUp();
        $adminRole = Role::where('name', 'admin')->first();
        $this->adminUser = User::factory()->create()->assignRole($adminRole);
    }

    public function test_dashboard_index_page_can_be_rendered(): void
    {
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.dashboard'))
                        ->assertViewIs('dashboard')
                        ->assertStatus(200);
    }

    public function test_admin_can_show_clients_and_users_count()
    {
        $users = User::factory(5)->create();
        $clients = Client::factory(5)->create();
        $response = $this->actingAs($this->adminUser)
                        ->get(route('admin.dashboard'))
                        ->assertViewHas('total_user', $users->count())
                        ->assertStatus(200);
        //$data = $response->getOriginalContent()->getData();
        dd($data);
    }
}
