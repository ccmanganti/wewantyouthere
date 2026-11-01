<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class InvitationWebsite extends Model {
 protected $fillable=['user_id','invitation_template_id','name','slug','custom_domain','domain_status','status','answers'];
 protected function casts(): array{return ['answers'=>'array'];}
 public function user(): BelongsTo{return $this->belongsTo(User::class);}
 public function template(): BelongsTo{return $this->belongsTo(InvitationTemplate::class,'invitation_template_id');}
}