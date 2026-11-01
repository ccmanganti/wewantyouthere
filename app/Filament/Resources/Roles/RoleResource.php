<?php

namespace App\Filament\Resources\Roles;

use App\Filament\Resources\Roles\Pages\ListRoles;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('Superadmin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(125)->unique(ignoreRecord: true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->formatStateUsing(fn (string $state): string => $state === 'Superadmin' ? 'Superadmin' : ucfirst($state))->searchable()->sortable(),
                TextColumn::make('users_count')->counts('users')->label('Users'),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->modalHeading('Create role')
                    ->form([TextInput::make('name')->required()->maxLength(125)->unique()])
                    ->mutateDataUsing(fn (array $data): array => [...$data, 'guard_name' => 'web']),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Edit role')
                    ->form([TextInput::make('name')->required()->maxLength(125)->unique(ignoreRecord: true)])
                    ->hidden(fn (Role $record): bool => in_array($record->name, ['Superadmin', 'User', 'Affiliate', 'Associate'], true)),
                DeleteAction::make()
                    ->hidden(fn (Role $record): bool => in_array($record->name, ['Superadmin', 'User', 'Affiliate', 'Associate'], true) || $record->users()->exists()),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ListRoles::route('/')];
    }
}
