<?php

namespace App\Filament\Customer\Resources\Invitations;

use App\Filament\Customer\Resources\Invitations\Pages\ListInvitations;
use App\Models\InvitationWebsite;
use App\Support\InvitationAccounts;
use App\Support\InvitationWebsiteManager;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class InvitationResource extends Resource
{
    protected static ?string $model = InvitationWebsite::class;

    protected static ?string $slug = 'invitations';

    protected static ?string $navigationLabel = 'My Invitations';

    protected static ?string $modelLabel = 'Invitation';

    protected static ?string $pluralModelLabel = 'My Invitations';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-s-envelope-open';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Filament::auth()->id());
    }

    public static function canViewAny(): bool
    {
        return Filament::auth()->check();
    }

    public static function canCreate(): bool
    {
        // Creation is done through the guided public builder, never the resource table.
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return $record instanceof InvitationWebsite
            && (int) $record->user_id === (int) Filament::auth()->id();
    }

    public static function canDelete(Model $record): bool
    {
        return static::canEdit($record);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Invitation')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (InvitationWebsite $record): string =>
                        'wewantyouthere.com/i/' . $record->slug),
                TextColumn::make('template.name')->label('Design'),
                TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                    'published' => 'success',
                    'draft' => 'warning',
                    default => 'gray',
                }),
                TextColumn::make('updated_at')->label('Updated')->since()->sortable(),
            ])
            ->headerActions([
                Action::make('createInvitation')
                    ->label('Create invitation')
                    ->icon('heroicon-s-plus')
                    ->color('primary')
                    ->url(route('marketing.templates'))
                    ->visible(fn (): bool => InvitationAccounts::canCreateWebsite(Filament::auth()->user())),
            ])
            ->recordActions([
                Action::make('visit')
                    ->label('View website')
                    ->icon('heroicon-s-arrow-top-right-on-square')
                    ->url(fn (InvitationWebsite $record): string => route('wedding.show', $record->slug))
                    ->openUrlInNewTab()
                    ->visible(fn (InvitationWebsite $record): bool => $record->status === 'published'),
                EditAction::make('quickEdit')
                    ->label('Quick edit')
                    ->icon('heroicon-s-pencil-square')
                    ->modalHeading('Edit invitation settings')
                    ->modalDescription('Update your title, link, or visibility without leaving this page.')
                    ->form([
                        TextInput::make('name')
                            ->label('Invitation name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->label('Website link')
                            ->prefix('wewantyouthere.com/i/')
                            ->helperText('Shareable links and QR codes using your old URL will redirect to your new website address.')
                            ->required()
                            ->minLength(3)
                            ->maxLength(72)
                            ->rules(['regex:/\A[a-z0-9]+(?:-[a-z0-9]+)*\z/D']),
                        Select::make('status')
                            ->label('Website visibility')
                            ->options(['published' => 'Published — available to guests', 'draft' => 'Unpublished — private'])
                            ->required(),
                    ])
                    ->using(function (InvitationWebsite $record, array $data): InvitationWebsite {
                        abort_unless(static::canEdit($record), 403);
                        return InvitationWebsiteManager::updateOwned(
                            $record,
                            (int) Filament::auth()->id(),
                            $data['name'],
                            $data['slug'],
                            $data['status'],
                        );
                    }),
                Action::make('managePhotos')
                    ->label('Manage photos')
                    ->icon('heroicon-s-photo')
                    ->url(fn (InvitationWebsite $record): string => route('wedding.photos.manage', $record))
                    ->visible(fn (InvitationWebsite $record): bool => ($record->template->settings['theme'] ?? '') === 'royal_burgundy'),
                Action::make('editContent')
                    ->label('Edit details')
                    ->icon('heroicon-s-document-text')
                    ->color('gray')
                    ->modalHeading('Edit your wedding details')
                    ->modalDescription('Update any information and decide which sections guests can see.')
                    ->modalWidth('7xl')
                    ->form(fn (InvitationWebsite $record): array => static::contentFields($record))
                    ->fillForm(function (InvitationWebsite $record): array {
                        $answers = $record->answers ?? [];
                        return [
                            'answers' => $answers,
                            'sections' => $answers['_sections'] ?? [],
                        ];
                    })
                    ->action(function (InvitationWebsite $record, array $data): void {
                        $website = InvitationWebsite::query()
                            ->where('user_id', Filament::auth()->id())
                            ->findOrFail($record->id);

                        $groupDefs = config('wedding_builder.groups', []);
                        $activeKeys = $website->template->eventType->questions()
                            ->where('is_enabled', true)->pluck('key')->all();
                        $submittedAnswers = array_intersect_key($data['answers'] ?? [], array_flip($activeKeys));
                        $answers = array_replace($website->answers ?? [], $submittedAnswers);
                        $existingSections = $answers['_sections'] ?? [];

                        foreach ($groupDefs as $key => $def) {
                            $existingSections[$key] = ! ($def['hideable'] ?? false)
                                || (bool) ($data['sections'][$key] ?? $existingSections[$key] ?? true);
                        }

                        $website->update([
                            'answers' => array_merge($answers, ['_sections' => $existingSections]),
                        ]);
                    }),
                DeleteAction::make()
                    ->label('Delete')
                    ->modalHeading('Permanently delete this invitation?')
                    ->modalDescription('Your website and QR link will stop working. This action cannot be undone. Deleting your site frees your free-plan slot.')
                    ->requiresConfirmation()
                    ->after(function (InvitationWebsite $record): void {
                        Storage::disk('local')->deleteDirectory('wedding-sites/' . $record->id);
                    }),
            ])
            ->defaultSort('updated_at', 'desc')
            ->emptyStateHeading('Your first invitation starts here')
            ->emptyStateDescription('Choose a wedding design and build your invitation step by step. Your first website is free.');
    }

    private static function contentFields(InvitationWebsite $record): array
    {
        $questions = $record->template->eventType->questions()
            ->where('is_enabled', true)->orderBy('sort_order')->get();
        $groups = [];

        foreach (config('wedding_builder.groups', []) as $key => $groupDef) {
            $inputs = [];

            if ($groupDef['hideable'] ?? false) {
                $inputs[] = Toggle::make('sections.' . $key)
                    ->label('Show this section on my website')
                    ->default(true);
            }

            foreach ($questions->where('group_key', $key) as $question) {
                $statePath = 'answers.' . $question->key;
                $field = match ($question->type) {
                    'textarea' => Textarea::make($statePath)->rows(3),
                    'date' => TextInput::make($statePath)->type('date'),
                    'time' => TextInput::make($statePath)->type('time'),
                    'number' => TextInput::make($statePath)->numeric()->minValue(0),
                    'url' => TextInput::make($statePath)->url(),
                    'email' => TextInput::make($statePath)->email(),
                    default => TextInput::make($statePath),
                };
                $inputs[] = $field
                    ->label($question->label)
                    ->helperText($question->help_text ?: null)
                    ->required($question->is_required && ! ($groupDef['hideable'] ?? false))
                    ->maxLength(in_array($question->type, ['text','textarea'], true) ? 2000 : null);
            }

            if (! $inputs) {
                continue;
            }

            $groups[] = Section::make($groupDef['title'])
                ->description($groupDef['description'])
                ->collapsible()
                ->collapsed($key !== 'couple')
                ->schema($inputs);
        }

        return $groups;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInvitations::route('/'),
        ];
    }
}
