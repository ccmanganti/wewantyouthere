<?php
namespace App\Filament\Resources\EventQuestions;
use App\Models\EventQuestion;
use App\Filament\Resources\EventQuestions\Pages\ListEventQuestions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
class EventQuestionResource extends Resource {
 protected static ?string $model=EventQuestion::class;
 protected static string|\BackedEnum|null $navigationIcon='heroicon-o-question-mark-circle';
 public static function canViewAny(): bool {return auth()->user()?->hasRole('Superadmin')??false;}
 public static function form(Schema $schema): Schema{return $schema->components([
 Select::make('event_type_id')->relationship('eventType','name')->required(),
 TextInput::make('key')->required()->alphaDash()->maxLength(255),
 TextInput::make('label')->required(),
 Select::make('type')->options(array_combine(['text','textarea','date','time','number','url','email'],['Text','Long text','Date','Time','Number','URL','Email']))->required(),
 TextInput::make('sort_order')->numeric()->default(0)->required(),
 Toggle::make('is_required'),Toggle::make('is_enabled')->default(true),
 ]);}
 public static function table(Table $table): Table{return $table->columns([
 TextColumn::make('eventType.name')->label('Event')->sortable(),
 TextColumn::make('label')->searchable(),
 TextColumn::make('key')->searchable(),
 TextColumn::make('type'),
 ToggleColumn::make('is_required'),
 ToggleColumn::make('is_enabled'),
 ])->headerActions([CreateAction::make()->modalHeading('Add question')])->recordActions([EditAction::make()->modalHeading('Edit question')])->defaultSort('sort_order');}
 public static function getPages(): array{return ['index'=>ListEventQuestions::route('/')];}
}