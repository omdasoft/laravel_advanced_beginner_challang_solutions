<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
class AuthTest extends TestCase
{
    use RefreshDatabase;
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

   public function test_login_page_is_the_default_page(): void
   {
       $response = $this->get('/')
                       ->assertRedirect('/login')
                       ->assertStatus(302);
   }

   public function test_unauthorized_user_redirected_to_login_page() {
       $response = $this->get(route('admin.dashboard'))
                       ->assertRedirect('/login')
                       ->assertStatus(302);
   }

   public function test_authorized_user_redirected_to_dashboard_page() {
       $user = User::factory()->create();
       $response = $this->actingAs($user)
                       ->get(route('admin.dashboard'))
                       ->assertViewIs('dashboard')
                       ->assertStatus(200);
   }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
