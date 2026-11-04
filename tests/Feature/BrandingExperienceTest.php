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

    public function test_expected_uploaded_raster_brand_assets_are_used_instead_of_svg_logos(): void
    {
        // The user uploads these PNGs directly to the Hostinger public web root.
        // Do not make repository CI depend on assets that are not in the Git repository.
        $layout = file_get_contents(resource_path('views/layouts/wwyt.blade.php'));
        $branding = file_get_contents(resource_path('views/filament/customer/navigation/brand-logo.blade.php'));

        $this->assertStringContainsString("brand/wwyt/logo-white.png", $layout);
        $this->assertStringContainsString("brand/wwyt/favicon.png", $layout);
        $this->assertStringContainsString("brand/wwyt/logo-white.png", $branding);
        $this->assertStringContainsString("brand/wwyt/logo-primary.png", $branding);

        $this->assertStringNotContainsString("branding/wwyt-horizontal-light.svg", $layout);
        $this->assertStringNotContainsString("branding/wwyt-horizontal-color.svg", $branding);
    }

    public function test_homepage_uses_new_brand_assets_and_scroll_line_decorations(): void
    {
        $this->get('/')->assertOk()
            ->assertSee('brand/wwyt/logo-white.png')
            ->assertSee('brand/wwyt/seal-3d.png')
            ->assertSee('mkt-journey-line')
            ->assertSee('mkt-line-reveal')
            ->assertSee('fa-solid fa-qrcode')
            ->assertSee('fa-solid fa-arrow-right');
    }

    public function test_login_and_registration_have_full_website_navigation(): void
    {
        $this->get('/app/login')->assertOk()
            ->assertSee('wwyt-auth-global-nav')
            ->assertSee('brand/wwyt/logo-white.png')
            ->assertSee('brand/wwyt/seal-3d.png')
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
            ->assertSee('logo-primary.png')
            ->assertSee('brand/wwyt/seal-outline.png')
            ->assertSee('Back to website')
            ->assertSee('Explore invitation designs')
            ->assertSee('fa-solid fa-chevron-right');
    }
}
