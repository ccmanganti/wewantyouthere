<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationSlugRedirect extends Model
{
    protected $fillable = ['invitation_website_id', 'slug'];

    public function website(): BelongsTo
    {
        return $this->belongsTo(InvitationWebsite::class, 'invitation_website_id');
    }
}
