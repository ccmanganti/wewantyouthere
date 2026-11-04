<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\WeddingBuilderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandingExperienceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(WeddingBuilderSeeder::class);
    }

    public function test_required_brand_logo_variants_are_available(): void
    {
        foreach (['color', 'light', 'dark', 'outline', '3d'] as $variant) {
            foreach (['icon', 'horizontal'] as $form) {
                $filename = public_path("branding/wwyt-{$form}-{$variant}.svg");
                $this->assertFileExists($filename);
                $this->assertStringContainsString('<svg', file_get_contents($filename));
            }
        }
    }

    public function test_homepage_uses_new_brand_assets_and_scroll_line_decorations(): void
    {
        $this->get('/')->assertOk()
            ->assertSee('branding/wwyt-horizontal-light.svg')
            ->assertSee('branding/wwyt-icon-3d.svg')
            ->assertSee('mkt-journey-line')
            ->assertSee('mkt-line-reveal');
    }

    public function test_login_and_registration_have_full_website_navigation(): void
    {
        $this->get('/app/login')->assertOk()
            ->assertSee('wwyt-auth-global-nav')
            ->assertSee('branding/wwyt-horizontal-light.svg')
            ->assertSee('branding/wwyt-icon-3d.svg')
            ->assertSee('Templates');

        $this->get('/app/register')->assertOk()
            ->assertSee('wwyt-auth-global-nav')
            ->assertSee('Back to home');
    }

    public function test_customer_workspace_includes_home_link_and_branded_cards(): void
    {
        $user = User::create([
            'name' => 'Customer One',
            'email' => 'branded-customer@example.test',
            'password' => 'very-secure-test-password',
        ]);

        $this->actingAs($user)->get('/app')->assertOk()
            ->assertSee('wwyt-dashboard')
            ->assertSee('wwyt-panel-topnav')
            ->assertSee('wwyt-horizontal-color.svg')
            ->assertSee('branding/wwyt-icon-outline.svg')
            ->assertSee('Back to website')
            ->assertSee('Explore invitation designs');
    }
}
