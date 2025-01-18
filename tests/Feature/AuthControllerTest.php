<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_the_login_form()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function it_allows_user_to_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'), // password123 is the password
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => 'password123',
        ];

        $response = $this->post(route('login'), $credentials);

        $response->assertRedirect(route('blog.index'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_redirects_user_to_admin_dashboard_if_admin_logs_in()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('adminpassword'), // adminpassword is the password
        ]);

        $credentials = [
            'email' => $admin->email,
            'password' => 'adminpassword',
        ];

        $response = $this->post(route('login'), $credentials);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    /** @test */
    public function it_displays_invalid_credentials_error_for_invalid_login()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ];

        $response = $this->post(route('login'), $credentials);

        $response->assertSessionHasErrors(['email' => 'Invalid credentials.']);
        $this->assertGuest();
    }

    /** @test */
    public function it_logs_out_user_and_redirects_to_login_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    /** @test */
    public function it_shows_the_register_form()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /** @test */
    public function it_registers_a_new_user()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('register'), $data);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
        $user = User::where('email', 'test@example.com')->first();
        $this->assertEquals('author', $user->role);
    }

    /** @test */
    public function it_fails_to_register_user_with_invalid_data()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'short',
        ];

        $response = $this->post(route('register'), $data);

        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }
}
