<?php

namespace App\Support;

use App\Models\EventQuestion;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Collection;

/**
 * Shared presentation rules for event questions across the invitation platform.
 *
 * The same ordering, widths and responsive columns are used for weddings,
 * birthdays, debuts, christenings, anniversaries, graduations, corporate
 * events, and event types added later. Field keys and validation stay intact.
 */
class InvitationFormLayout
{
    /** @return array<string, int> */
    private static function priorities(?string $eventTypeSlug): array
    {
        $specific = config('invitation_form_layout.types.' . ($eventTypeSlug ?? ''), []);
        $common = config('invitation_form_layout.common', []);

        return array_flip(array_values(array_unique(array_merge($specific, $common))));
    }

    /**
     * @param Collection<int, EventQuestion> $questions
     * @return Collection<int, EventQuestion>
     */
    public static function orderedQuestions(Collection $questions, ?string $eventTypeSlug): Collection
    {
        $priorities = self::priorities($eventTypeSlug);
        $offset = count($priorities);
        $base = $questions->values();

        return $base->sortBy(function (EventQuestion $question, int $index) use ($priorities, $offset): int {
            return array_key_exists($question->key, $priorities)
                ? $priorities[$question->key]
                : $offset + $index;
        })->values();
    }

    public static function isWide(EventQuestion $question): bool
    {
        return $question->type === 'textarea'
            || in_array($question->key, config('invitation_form_layout.wide_keys', []), true)
            || str_ends_with($question->key, '_address')
            || str_ends_with($question->key, '_map_url');
    }

    /** One column on mobile, two on tablets and desktop. */
    public static function columns(): array
    {
        return ['default' => 1, 'md' => 2];
    }

    public static function field(EventQuestion $question, bool $required = true): TextInput | Textarea
    {
        $path = 'answers.' . $question->key;
        $field = match ($question->type) {
            'textarea' => Textarea::make($path)->rows(3),
            'date' => TextInput::make($path)->type('date'),
            'time' => TextInput::make($path)->type('time'),
            'number' => TextInput::make($path)->numeric()->minValue(0),
            'url' => TextInput::make($path)->url(),
            'email' => TextInput::make($path)->email(),
            default => TextInput::make($path),
        };

        $field
            ->label($question->label)
            ->placeholder($question->placeholder ?: null)
            ->helperText($question->help_text ?: null)
            ->required($required && $question->is_required);

        if (in_array($question->type, ['text', 'textarea'], true)) {
            $field->maxLength(2000);
        }

        if (self::isWide($question)) {
            $field->columnSpanFull();
        }

        return $field;
    }

    /**
     * For non-wedding event types, organize the same questions in manageable
     * sections; unknown questions are still included in "Additional details".
     *
     * @param Collection<int, EventQuestion> $questions
     * @return array<string, array{title: string, questions: Collection}>
     */
    public static function sections(Collection $questions, ?string $eventTypeSlug): array
    {
        $sections = [
            'essentials' => ['title' => 'Event basics', 'questions' => collect()],
            'venue' => ['title' => 'Venue and directions', 'questions' => collect()],
            'people' => ['title' => 'People and program', 'questions' => collect()],
            'messages' => ['title' => 'Messages and guest details', 'questions' => collect()],
        ];

        foreach (self::orderedQuestions($questions, $eventTypeSlug) as $question) {
            $key = $question->key;
            $section = match (true) {
                in_array($key, ['event_title','event_date','event_time','child_name','mother_name',
                    'father_name','celebrant_name','debutante_name','age','couple_names',
                    'years_together','graduate_name','company_name','school_name','degree',
                    'theme','event_organizer'], true) => 'essentials',
                str_contains($key, 'venue'), str_contains($key, 'address'),
                    str_contains($key, 'map_url'), $key === 'church_name' => 'venue',
                str_contains($key, 'rsvp'), str_contains($key, 'guest'),
                    in_array($key, ['host_message','dress_code'], true) => 'messages',
                default => 'people',
            };

            $sections[$section]['questions']->push($question);
        }

        return array_filter($sections, fn (array $section) => $section['questions']->isNotEmpty());
    }
}
