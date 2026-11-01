<?php
namespace App\Filament\Resources\InvitationWebsites;
use App\Models\InvitationWebsite;
use App\Models\InvitationTemplate;
use App\Filament\Resources\InvitationWebsites\Pages\ListInvitationWebsites;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
class InvitationWebsiteResource extends Resource {
 protected static ?string $model=InvitationWebsite::class;
 protected static string|\BackedEnum|null $navigationIcon='heroicon-o-globe-alt';
 public static function canViewAny(): bool{return auth()->user()?->hasRole('Superadmin')??false;}
 public static function form(Schema $schema): Schema{return $schema->components([
 Select::make('user_id')->relationship('user','name')->searchable()->required(),
 Select::make('invitation_template_id')->label('Template')->relationship('template','name')->searchable()->required()->live(),
 TextInput::make('name')->required(),
 TextInput::make('slug')->required()->unique(ignoreRecord:true)->helperText('Invitation URL slug'),
 TextInput::make('custom_domain')->label('Custom domain')->placeholder('invite.example.com')->unique(ignoreRecord:true)->helperText('DNS ownership verification is required before domain activation.'),
 ...self::questionFields(),
 ]);}
 private static function questionFields(): array {
  return [\Filament\Schemas\Components\Section::make('Event details')->schema(function(\Filament\Schemas\Components\Utilities\Get $get):array {
   $template=InvitationTemplate::with('eventType.questions')->find($get('invitation_template_id'));
   if(!$template)return [];
   return $template->eventType->questions->where('is_enabled',true)->map(function($q){
    $field=match($q->type){
     'textarea'=>Textarea::make('answers.'.$q->key),
     'date'=>TextInput::make('answers.'.$q->key)->type('date'),
     'time'=>TextInput::make('answers.'.$q->key)->type('time'),
     'number'=>TextInput::make('answers.'.$q->key)->numeric(),
     'url'=>TextInput::make('answers.'.$q->key)->url(),
     'email'=>TextInput::make('answers.'.$q->key)->email(),
     default=>TextInput::make('answers.'.$q->key),
    };
    return $field->label($q->label)->required($q->is_required);
   })->all();
  })];
 }
 public static function table(Table $table): Table{return $table->columns([
 TextColumn::make('name')->searchable(),
 TextColumn::make('user.name')->label('Owner'),
 TextColumn::make('template.name')->label('Template'),
 TextColumn::make('slug')->searchable(),
 TextColumn::make('custom_domain'),
 SelectColumn::make('status')->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived']),
 TextColumn::make('domain_status')->label('Domain verification'),
 ])->headerActions([CreateAction::make()->modalHeading('Create invitation')])->recordActions([EditAction::make()->modalHeading('Edit invitation')]);}
 public static function getPages(): array{return ['index'=>ListInvitationWebsites::route('/')];}
}