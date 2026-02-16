<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_available()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_register_page_available()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_view_dashboard()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/dashboard')->assertStatus(200);
    }
}
