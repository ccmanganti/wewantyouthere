<?php

namespace App\Support;

use App\Models\User;

class InvitationAccounts
{
    public static function websiteLimit(User $user): ?int
    {
        // No checkout is enabled. Only an administrator may provision premium access.
        return $user->account_tier === 'premium' ? null : 1;
    }

    public static function canCreateWebsite(User $user): bool
    {
        $limit = self::websiteLimit($user);

        return $limit === null || $user->invitationWebsites()->count() < $limit;
    }

    public static function remainingSites(User $user): ?int
    {
        $limit = self::websiteLimit($user);

        return $limit === null ? null : max(0, $limit - $user->invitationWebsites()->count());
    }
}
