<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;
use Mockery;
use Tests\TestCase;

class GoogleLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    private function mockGoogle(string $id, string $email, bool $verified = true): void
    {
        Config::set('services.google.client_id', 'configured-client-id');
        Config::set('services.google.client_secret', 'configured-client-secret');
        Config::set('services.google.redirect', 'http://localhost/auth/google/callback');

        $profile = new GoogleUser;
        $profile->setRaw(['email_verified' => $verified]);
        $profile->map([
            'id' => $id,
            'email' => $email,
            'name' => 'Google Couple',
        ]);

        $provider = Mockery::mock();
        $provider->shouldReceive('user')->once()->andReturn($profile);
        Socialite::shouldReceive('driver')->with('google')->once()->andReturn($provider);
    }

    public function test_google_button_only_appears_when_google_is_configured(): void
    {
        Config::set('services.google.client_id', null);
        Config::set('services.google.client_secret', null);

        $this->get('/app/login')->assertOk()
            ->assertSee('Email sign-in is available now.')
            ->assertDontSee('Continue with Google');

        Config::set('services.google.client_id', 'configured-client-id');
        Config::set('services.google.client_secret', 'configured-client-secret');

        $this->get('/app/login')->assertOk()
            ->assertSee('Continue with Google')
            ->assertSee('/auth/google/redirect');
    }

    public function test_verified_google_user_can_register_a_free_customer_account(): void
    {
        $this->mockGoogle('google-user-1', 'new-google-user@example.test');

        $this->get('/auth/google/callback')->assertRedirect('/app');

        $user = User::where('email', 'new-google-user@example.test')->firstOrFail();
        $this->assertSame('google-user-1', $user->google_id);
        $this->assertNotNull($user->email_verified_at);
        $this->assertTrue($user->hasRole('User'));
        $this->assertSame('free', $user->account_tier);
        $this->assertAuthenticatedAs($user);
    }

    public function test_google_can_link_an_existing_account_with_the_same_verified_email(): void
    {
        $existing = User::create([
            'name' => 'Existing Couple',
            'email' => 'existing-google@example.test',
            'password' => 'original-password-123',
        ]);

        $this->mockGoogle('google-user-2', 'existing-google@example.test');
        $this->get('/auth/google/callback')->assertRedirect('/app');

        $this->assertSame($existing->id, auth()->id());
        $this->assertSame('google-user-2', $existing->fresh()->google_id);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('original-password-123', $existing->fresh()->password));
        $this->assertDatabaseCount('users', 1);
    }

    public function test_google_must_supply_a_verified_email(): void
    {
        $this->mockGoogle('google-unverified', 'unverified@example.test', false);

        $this->get('/auth/google/callback')->assertRedirect('/app/login')
            ->assertSessionHasErrors('google');

        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    public function test_google_id_cannot_overwrite_a_different_google_identity(): void
    {
        $user = User::create([
            'name' => 'Existing Couple',
            'email' => 'linked@example.test',
            'password' => 'original-password-123',
        ]);
        $user->forceFill(['google_id' => 'google-original'])->save();

        $this->mockGoogle('google-attacker', 'linked@example.test');

        $this->get('/auth/google/callback')->assertRedirect('/app/login')
            ->assertSessionHasErrors('google');

        $this->assertSame('google-original', $user->fresh()->google_id);
        $this->assertGuest();
    }

    public function test_google_signin_is_disabled_without_credentials(): void
    {
        Config::set('services.google.client_id', null);
        Config::set('services.google.client_secret', null);

        $this->get('/auth/google/redirect')->assertRedirect('/app/login')
            ->assertSessionHasErrors('google');
    }
}
