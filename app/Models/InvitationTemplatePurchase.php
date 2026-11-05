<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationTemplatePurchase extends Model
{
    protected $fillable = [
        'user_id', 'invitation_template_id', 'amount_cents', 'currency',
        'status', 'provider', 'provider_session_id', 'paid_at',
    ];

    protected function casts(): array
    {
        return ['paid_at' => 'datetime'];
    }
}
