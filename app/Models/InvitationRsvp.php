<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationRsvp extends Model
{
    protected $fillable = ['invitation_website_id','guest_name','attendance','guest_count','message'];

    protected function casts(): array
    {
        return ['guest_count' => 'integer'];
    }

    public function website(): BelongsTo
    {
        return $this->belongsTo(InvitationWebsite::class, 'invitation_website_id');
    }
}
