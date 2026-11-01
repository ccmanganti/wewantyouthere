<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class EventQuestion extends Model {
 protected $fillable=['event_type_id','key','label','type','options','is_required','is_enabled','sort_order'];
 protected function casts(): array{return ['options'=>'array','is_required'=>'boolean','is_enabled'=>'boolean'];}
 public function eventType(): BelongsTo{return $this->belongsTo(EventType::class);}
}