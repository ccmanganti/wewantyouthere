<?php

namespace Tests\Feature;

use App\Models\InvitationTemplate;
use App\Models\User;
use Database\Seeders\WeddingBuilderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketingPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(WeddingBuilderSeeder::class);
    }

    public function test_seo_landing_page_is_server_rendered_and_links_to_working_builder(): void
    {
        $this->get('/')->assertOk()
            ->assertSee('Free Wedding Invitation Website Maker Philippines')
            ->assertSee('YOUR BIGGEST MOMENTS.')
            ->assertSee('Make my invitation')
            ->assertSee('wedding-invitation-templates')
            ->assertSee('Ever After')
            ->assertSee('application/ld+json')
            ->assertSee('index,follow');
    }

    public function test_templates_gallery_detail_and_full_website_preview(): void
    {
        $this->get('/wedding-invitation-templates')->assertOk()
            ->assertSee('FIND YOUR')
            ->assertSee('Ever After')
            ->assertSee('mkt-template-search');

        $this->get('/wedding-invitation-templates/ever-after-classic')->assertOk()
            ->assertSee('What you can customize')
            ->assertSee('templates/ever-after-classic/preview');

        $this->get('/templates/ever-after-classic/preview')->assertOk()
            ->assertSee('Amelia')
            ->assertSee('wedding-ceremony')
            ->assertSee('noindex,nofollow');
    }

    public function test_unpublished_templates_are_not_indexed_as_public_products(): void
    {
        $template = InvitationTemplate::where('slug', 'ever-after-classic')->firstOrFail();
        $template->update(['status' => 'draft']);

        $this->get('/wedding-invitation-templates/ever-after-classic')->assertNotFound();
        $this->get('/templates/ever-after-classic/preview')->assertNotFound();

        $this->get('/sitemap.xml')->assertOk()->assertDontSee('/wedding-invitation-templates/ever-after-classic');
    }

    public function test_sitemap_robots_and_legal_notices_are_accessible(): void
    {
        $this->get('/sitemap.xml')->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('/wedding-invitation-templates/ever-after-classic')
            ->assertSee('<urlset', false);

        $this->get('/robots.txt')->assertOk()
            ->assertSee('Sitemap:')
            ->assertSee('Disallow: /admin/');

        $this->get('/privacy')->assertOk()->assertSee('Privacy policy.');
        $this->get('/terms')->assertOk()->assertSee('Terms of service.');
    }

    public function test_accounts_with_one_website_are_sent_to_management_instead_of_another_builder(): void
    {
        $user = User::create([
            'name' => 'Wedding Owner', 'email' => 'seo-owner@example.test',
            'password' => 'secure-password-123',
        ]);

        \App\Models\InvitationWebsite::create([
            'user_id' => $user->id,
            'invitation_template_id' => InvitationTemplate::where('slug', 'ever-after-classic')->firstOrFail()->id,
            'name' => 'Our Wedding',
            'slug' => 'seo-owner-invitation',
            'status' => 'published',
        ]);

        $this->actingAs($user)->get('/')->assertOk()->assertSee('Manage my invitation');
        $this->get('/templates/wedding/ever-after-classic')->assertRedirect('/app/invitations');
    }
}
