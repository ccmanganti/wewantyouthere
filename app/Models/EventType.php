<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class EventType extends Model {
 protected $fillable=['name','slug','is_active'];
 protected function casts(): array{return ['is_active'=>'boolean'];}
 public function questions(): HasMany{return $this->hasMany(EventQuestion::class)->orderBy('sort_order');}
 public function templates(): HasMany{return $this->hasMany(InvitationTemplate::class);}
}