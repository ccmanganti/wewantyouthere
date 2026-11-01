<?php
namespace App\Filament\Resources\EventTypes;
use App\Models\EventType;
use App\Filament\Resources\EventTypes\Pages\ListEventTypes;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
class EventTypeResource extends Resource {
 protected static ?string $model=EventType::class;
 protected static string|\BackedEnum|null $navigationIcon='heroicon-o-calendar-days';
 public static function canViewAny(): bool {return auth()->user()?->hasRole('Superadmin')??false;}
 public static function form(Schema $schema): Schema{return $schema->components([TextInput::make('name')->required(),TextInput::make('slug')->required()->unique(ignoreRecord:true)]);}
 public static function table(Table $table): Table{return $table->columns([TextColumn::make('name')->searchable(),TextColumn::make('slug'),ToggleColumn::make('is_active'),TextColumn::make('questions_count')->counts('questions')])->headerActions([CreateAction::make()->modalHeading('Add event type')])->recordActions([EditAction::make()->modalHeading('Edit event type')]);}
 public static function getPages(): array{return ['index'=>ListEventTypes::route('/')];}
}