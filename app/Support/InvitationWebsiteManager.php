<?php

namespace App\Support;

use App\Models\InvitationSlugRedirect;
use App\Models\InvitationWebsite;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InvitationWebsiteManager
{
    public static function slugTaken(string $slug, ?int $exceptWebsiteId = null): bool
    {
        if (InvitationWebsite::query()
            ->where('slug', $slug)
            ->when($exceptWebsiteId, fn ($query) => $query->whereKeyNot($exceptWebsiteId))
            ->exists()) {
            return true;
        }

        return InvitationSlugRedirect::query()->where('slug', $slug)
            ->when($exceptWebsiteId, fn ($query) => $query->where('invitation_website_id', '!=', $exceptWebsiteId))
            ->exists();
    }

    public static function updateOwned(
        InvitationWebsite $website,
        int $ownerId,
        string $name,
        string $slug,
        string $status,
    ): InvitationWebsite {
        return DB::transaction(function () use ($website, $ownerId, $name, $slug, $status) {
            $locked = InvitationWebsite::query()
                ->where('user_id', $ownerId)
                ->lockForUpdate()
                ->findOrFail($website->id);

            if (self::slugTaken($slug, $locked->id)) {
                throw ValidationException::withMessages([
                    'slug' => 'This invitation link has already been taken.',
                ]);
            }

            $oldSlug = $locked->slug;

            if ($oldSlug !== $slug) {
                // Reusing a previous URL of this same website is allowed.
                InvitationSlugRedirect::query()
                    ->where('slug', $slug)
                    ->where('invitation_website_id', $locked->id)
                    ->delete();

                $locked->update([
                    'name' => $name,
                    'slug' => $slug,
                    'status' => $status,
                ]);

                InvitationSlugRedirect::firstOrCreate([
                    'slug' => $oldSlug,
                ], [
                    'invitation_website_id' => $locked->id,
                ]);
            } else {
                $locked->update(['name' => $name, 'status' => $status]);
            }

            return $locked->fresh();
        });
    }
}
