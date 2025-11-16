<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**php artisan test --filter LoginTestphp 
     * A basic feature test example.
     */

    public function test_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('layouts.guest.login');
        $response->assertViewHas('title', 'Login');
    }

    public function test_login_post_success()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect(RouteServiceProvider::HOME)
                ->assertStatus(302);
    }

    public function test_login_post_failure()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password-salah',
        ]);

        $this->assertGuest();

        $response->assertSessionHas('error', 'Username atau password salah');
        $response->assertSessionHasInput('username');

        $response->assertRedirect()
                ->assertStatus(302);
    }
}
