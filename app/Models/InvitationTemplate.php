<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class InvitationTemplate extends Model {
 protected $fillable=['event_type_id','creator_id','name','slug','code_path','thumbnail_path','status','is_premium','version','settings'];
 protected function casts(): array{return ['settings'=>'array','is_premium'=>'boolean'];}
 public function eventType(): BelongsTo{return $this->belongsTo(EventType::class);}
 public function creator(): BelongsTo{return $this->belongsTo(User::class,'creator_id');}
}