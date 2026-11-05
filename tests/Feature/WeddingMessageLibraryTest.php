<?php

namespace Tests\Feature;

use App\Models\EventQuestion;
use App\Models\WeddingMessageTemplate;
use Database\Seeders\RoyalBurgundyWeddingSeeder;
use Database\Seeders\WeddingMessageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeddingMessageLibraryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoyalBurgundyWeddingSeeder::class);
    }

    public function test_library_seeds_fifty_unique_suggestions_per_category_and_is_idempotent(): void
    {
        $catalog = config('wedding_message_library');
        $this->assertCount(10, $catalog);
        foreach (array_keys($catalog) as $category) {
            $this->assertSame(50, WeddingMessageTemplate::where('category', $category)->count());
            $this->assertSame(50, WeddingMessageTemplate::where('category', $category)
                ->distinct('content_hash')->count('content_hash'));
        }
        $this->assertSame(500, WeddingMessageTemplate::count());
        $this->seed(WeddingMessageSeeder::class);
        $this->assertSame(500, WeddingMessageTemplate::count());
    }

    public function test_anonymous_builder_can_generate_and_replace_a_quote_without_repeating_the_previous_one(): void
    {
        $route = '/templates/wedding/royal-burgundy-wedding/generate-message';
        $first = $this->getJson($route . '?field=hero_quote')->assertOk()
            ->assertJsonStructure(['id', 'content'])
            ->json();

        $this->assertNotEmpty($first['content']);
        $this->assertSame('quote', WeddingMessageTemplate::findOrFail($first['id'])->category);

        $second = $this->getJson($route . '?field=hero_quote&exclude=' . $first['id'])
            ->assertOk()->json();
        $this->assertNotSame($first['id'], $second['id']);
    }

    public function test_unapproved_or_disabled_fields_cannot_be_generated(): void
    {
        $route = '/templates/wedding/royal-burgundy-wedding/generate-message';
        $this->getJson($route . '?field=contact_email')->assertUnprocessable();
        $this->getJson($route . '?field=not_a_real_field')->assertUnprocessable();

        EventQuestion::where('key', 'host_message')->update(['is_enabled' => false]);
        $this->getJson($route . '?field=host_message')->assertNotFound();
        $this->getJson('/templates/wedding/not-a-real-design/generate-message?field=hero_quote')->assertNotFound();
    }

    public function test_editor_offers_database_generation_and_direct_preview_editing(): void
    {
        $this->get('/templates/wedding/royal-burgundy-wedding')->assertOk()
            ->assertSee('data-generate-url=', false)
            ->assertSee('data-generate-field="host_message"', false)
            ->assertSee('data-generate-field="hero_quote"', false)
            ->assertDontSee('data-generate-field="event_date"', false)
            ->assertSee('data-undo-generated="host_message"', false)
            ->assertSee('Click text in the preview to edit it here.');
    }
}
