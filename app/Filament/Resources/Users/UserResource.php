<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('Superadmin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::fields());
    }

    public static function fields(): array
    {
        return [
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('email')->email()->required()->maxLength(255)->unique(ignoreRecord: true),
            TextInput::make('password')->password()->revealable()->minLength(8)
                ->required(fn (string $operation): bool => $operation === 'create')
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->helperText('Leave blank when editing to keep the current password.'),
            Select::make('role')
                ->label('Role')
                ->options(fn (): array => Role::query()->where('guard_name', 'web')->pluck('name', 'name')->mapWithKeys(fn (string $name, string $key): array => [$key => match ($name) { 'Superadmin' => 'Superadmin', default => ucfirst($name) }])->all())
                ->required()
                ->dehydrated(false),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                SelectColumn::make('role')
                    ->label('Role (quick edit)')
                    ->options(fn (): array => Role::query()->where('guard_name', 'web')->pluck('name', 'name')->mapWithKeys(fn (string $name, string $key): array => [$key => match ($name) { 'Superadmin' => 'Superadmin', default => ucfirst($name) }])->all())
                    ->getStateUsing(fn (User $record): ?string => $record->getRoleNames()->first())
                    ->updateStateUsing(function (User $record, ?string $state): void {
                        if (! auth()->user()?->hasRole('Superadmin')) {
                            abort(403);
                        }

                        if ($record->is(auth()->user()) && $state !== 'Superadmin') {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                'role' => 'You cannot remove your own superadmin access.',
                            ]);
                        }

                        if ($state && Role::findByName($state, 'web')) {
                            $record->syncRoles([$state]);
                        }
                    }),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->modalHeading('Create user')
                    ->form(static::fields())
                    ->using(function (array $data): User {
                        $role = $data['role'];
                        unset($data['role']);
                        $user = User::create($data);
                        $user->assignRole($role);

                        return $user;
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Edit user')
                    ->form(static::fields())
                    ->fillForm(fn (User $record): array => [
                        'name' => $record->name,
                        'email' => $record->email,
                        'role' => $record->getRoleNames()->first(),
                    ])
                    ->using(function (User $record, array $data): User {
                        $role = $data['role'];
                        unset($data['role']);

                        if ($record->is(auth()->user()) && $role !== 'Superadmin') {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                'role' => 'You cannot remove your own superadmin access.',
                            ]);
                        }

                        $record->update($data);
                        $record->syncRoles([$role]);

                        return $record;
                    }),
                DeleteAction::make()
                    ->hidden(fn (User $record): bool => $record->is(auth()->user()) || $record->hasRole('Superadmin')),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return ['index' => ListUsers::route('/')];
    }
}
