<?php
namespace App\Filament\Resources\InvitationTemplates;
use App\Models\InvitationTemplate;
use App\Filament\Resources\InvitationTemplates\Pages\ListInvitationTemplates;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
class InvitationTemplateResource extends Resource {
 protected static ?string $model=InvitationTemplate::class;
 protected static string|\BackedEnum|null $navigationIcon='heroicon-o-swatch';
 public static function canViewAny(): bool {return auth()->user()?->hasRole('Superadmin')??false;}
 public static function form(Schema $schema): Schema{return $schema->components([
 TextInput::make('name')->required(),
 TextInput::make('slug')->required()->unique(ignoreRecord:true),
 Select::make('event_type_id')->relationship('eventType','name')->required(),
 FileUpload::make('code_path')->label('HTML template source')->disk('local')->directory('invitation-templates')->acceptedFileTypes(['text/html','text/plain'])->required(fn (string $operation): bool => $operation === 'create')->helperText('Upload a static .html template using {{event_title}} placeholders. Scripts and PHP are not supported.'),
 FileUpload::make('thumbnail_path')->image()->disk('public')->directory('template-thumbnails'),
 Select::make('status')->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived'])->required()->default('draft'),
 Toggle::make('is_premium'),
 ]);}
 public static function table(Table $table): Table{return $table->columns([
 TextColumn::make('name')->searchable(),TextColumn::make('eventType.name')->label('Event'),
 SelectColumn::make('status')->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived']),
 TextColumn::make('version')->sortable(),
 ])->headerActions([CreateAction::make()->modalHeading('Upload template')->mutateDataUsing(fn(array $data):array=>[...$data,'creator_id'=>auth()->id()])])->recordActions([EditAction::make()->modalHeading('Edit template')]);}
 public static function getPages(): array{return ['index'=>ListInvitationTemplates::route('/')];}
}