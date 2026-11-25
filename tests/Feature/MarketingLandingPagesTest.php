<?php

namespace Tests\Feature;

use Database\Seeders\WeddingBuilderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketingLandingPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.canonical_base' => 'https://wewantyouthere.com']);
        $this->seed(WeddingBuilderSeeder::class);
    }

    public function test_public_landing_pages_have_unique_metadata_and_are_in_the_sitemap(): void
    {
        $pages = config('marketing_pages');
        $this->assertCount(8, $pages);
        $this->assertCount(count($pages), array_unique(array_column($pages, 'title')));
        $this->assertCount(count($pages), array_unique(array_column($pages, 'description')));
        $sitemap = $this->get('/sitemap.xml')->assertOk();
        foreach ($pages as $slug => $page) {
            $this->get('/'.$slug)
                ->assertOk()
                ->assertSee($page['h1'])
                ->assertSee('content="'.e($page['description']).'"', false)
                ->assertSee('rel="canonical" href="https://wewantyouthere.com/'.$slug.'"', false)
                ->assertSee('content="index,follow"', false)
                ->assertSee('BreadcrumbList');
            $sitemap->assertSee('<loc>https://wewantyouthere.com/'.$slug.'</loc>', false);
        }
        $sitemap->assertDontSee('https://wewantyouthere.com/i/', false)
            ->assertDontSee('/templates/wedding/', false)
            ->assertDontSee('/preview</loc>', false);
        $this->get('/not-a-marketing-page')->assertNotFound();
        $this->assertGuest();
    }

    public function test_template_pages_and_preview_privacy_are_preserved(): void
    {
        $this->get('/wedding-invitation-templates')->assertOk();
        $this->get('/wedding-invitation-templates/ever-after-classic')->assertOk()
            ->assertSee('Style and customization');
        $this->get('/templates/ever-after-classic/preview')->assertOk()
            ->assertSee('noindex,nofollow');
        $this->get('/templates/wedding/ever-after-classic')->assertOk()
            ->assertSee('noindex,nofollow');
        $this->get('/pricing')->assertOk()->assertSee('RSVP + email notifications');
        $this->get('/wedding-website-examples')->assertOk()->assertSee('Ever After');
    }

    public function test_homepage_links_to_each_marketing_page(): void
    {
        $response = $this->get('/')->assertOk();
        foreach (array_keys(config('marketing_pages')) as $slug) {
            $response->assertSee(route('marketing.landing', ['page' => $slug]), false);
        }
    }
}
