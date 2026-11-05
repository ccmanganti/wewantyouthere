<?php

namespace Tests\Feature;

use App\Filament\Customer\Resources\Invitations\Pages\ListInvitations;
use App\Models\EventType;
use App\Models\InvitationTemplate;
use App\Models\InvitationWebsite;
use App\Models\User;
use App\Support\InvitationFormLayout;
use Database\Seeders\EventTypeQuestionSeeder;
use Database\Seeders\RoleSeeder;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InvitationFormLayoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(EventTypeQuestionSeeder::class);
    }

    public function test_every_event_type_uses_shared_responsive_columns_and_field_priority(): void
    {
        $examples = [
            'wedding' => ['bride_name', 'groom_name'],
            'christening' => ['child_name', 'mother_name', 'father_name'],
            'birthday' => ['celebrant_name', 'age'],
            'debut' => ['debutante_name', 'eighteen_roses'],
            'anniversary' => ['couple_names', 'years_together'],
            'graduation' => ['graduate_name', 'school_name'],
            'corporate-event' => ['company_name', 'event_organizer'],
        ];

        $this->assertSame(['default' => 1, 'md' => 2], InvitationFormLayout::columns());

        foreach ($examples as $slug => $keys) {
            $event = EventType::where('slug', $slug)->firstOrFail();
            $questions = InvitationFormLayout::orderedQuestions(
                $event->questions()->where('is_enabled', true)->get(),
                $slug,
            );

            $this->assertSame('event_title', $questions->first()->key, $slug);
            $this->assertSame($keys, $questions->whereIn('key', $keys)->pluck('key')->all(), $slug);
            $this->assertTrue(
                InvitationFormLayout::isWide($questions->firstWhere('key', 'event_title')),
                $slug,
            );
            $this->assertTrue(
                InvitationFormLayout::isWide($questions->firstWhere('key', 'host_message')),
                $slug,
            );
        }
    }

    public function test_christening_parent_names_pair_and_long_lists_span_two_columns(): void
    {
        $event = EventType::where('slug', 'christening')->firstOrFail();
        $questions = InvitationFormLayout::orderedQuestions($event->questions, 'christening');

        $this->assertSame('mother_name', $questions->firstWhere('key', 'mother_name')->key);
        $this->assertFalse(InvitationFormLayout::isWide($questions->firstWhere('key', 'mother_name')));
        $this->assertFalse(InvitationFormLayout::isWide($questions->firstWhere('key', 'father_name')));
        $this->assertTrue(InvitationFormLayout::isWide($questions->firstWhere('key', 'godfathers')));
        $this->assertTrue(InvitationFormLayout::isWide($questions->firstWhere('key', 'godmothers')));

        $groups = InvitationFormLayout::sections($event->questions, 'christening');
        $this->assertArrayHasKey('essentials', $groups);
        $this->assertArrayHasKey('venue', $groups);
        $this->assertArrayHasKey('people', $groups);
        $this->assertArrayHasKey('messages', $groups);
        $this->assertContains('child_name', $groups['essentials']['questions']->pluck('key')->all());
        $this->assertContains('church_name', $groups['venue']['questions']->pluck('key')->all());
    }

    public function test_customer_can_edit_a_non_wedding_invitation_using_event_specific_fields(): void
    {
        $user = User::create([
            'name' => 'Christening Customer',
            'email' => 'christening-layout@example.test',
            'password' => 'secure-password-123',
        ]);
        $event = EventType::where('slug', 'christening')->firstOrFail();
        $template = InvitationTemplate::create([
            'event_type_id' => $event->id,
            'creator_id' => $user->id,
            'name' => 'Christening Form Layout',
            'slug' => 'christening-form-layout',
            'status' => 'published',
        ]);
        $website = InvitationWebsite::create([
            'user_id' => $user->id,
            'invitation_template_id' => $template->id,
            'name' => 'Christening Invitation',
            'slug' => 'christening-layout-test',
            'status' => 'draft',
            'answers' => [],
        ]);

        $this->actingAs($user);
        Filament::setCurrentPanel(Filament::getPanel('app'));

        Livewire::test(ListInvitations::class)
            ->assertSuccessful()
            ->callAction(TestAction::make('editContent')->table($website), data: [
                'answers' => [
                    'event_title' => 'Our Child\'s Christening',
                    'event_date' => '2027-05-07',
                    'venue_name' => 'St. Anne Chapel',
                    'child_name' => 'Mia',
                    'mother_name' => 'Anna',
                    'father_name' => 'Marco',
                    'godfathers' => "John\nPeter",
                    'godmothers' => "Mary\nJane",
                    'host_message' => 'Celebrate with our family.',
                ],
            ])
            ->assertHasNoFormErrors();

        $answers = $website->fresh()->answers;
        $this->assertSame('Mia', $answers['child_name']);
        $this->assertSame('Anna', $answers['mother_name']);
        $this->assertSame('Marco', $answers['father_name']);
        $this->assertSame("John\nPeter", $answers['godfathers']);
        $this->assertSame('St. Anne Chapel', $answers['venue_name']);
    }
}
