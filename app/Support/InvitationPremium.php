<?php

namespace App\Support;

use App\Models\InvitationTemplate;
use App\Models\InvitationTemplatePurchase;
use App\Models\User;

class InvitationPremium
{
    public const FEATURES = [
        'maps' => ['name' => 'Google Maps integration', 'detail' => 'Church, ceremony and reception maps', 'icon' => 'fa-map-location-dot'],
        'rsvp' => ['name' => 'RSVP + email notifications', 'detail' => 'Receive guest replies and owner alerts', 'icon' => 'fa-envelope-open-text'],
        'music' => ['name' => 'Music & interactive sounds', 'detail' => 'Two music tracks, custom uploads and theme-specific effects', 'icon' => 'fa-music'],
        'video' => ['name' => 'Video embed', 'detail' => 'Prenup, teaser or a personal message', 'icon' => 'fa-film'],
        'program' => ['name' => 'Wedding programme', 'detail' => 'Ceremony schedule and event timeline', 'icon' => 'fa-list-check'],
        'entourage' => ['name' => 'Wedding entourage', 'detail' => 'Sponsors, ninong, ninang and wedding party', 'icon' => 'fa-people-group'],
        'ceremony' => ['name' => 'Ceremony details', 'detail' => 'Expanded ceremony details and vows', 'icon' => 'fa-church'],
    ];

    public static function has(?User $user, InvitationTemplate $template): bool
    {
        if (!$user) return false;
        return InvitationTemplatePurchase::query()
            ->where('user_id', $user->id)
            ->where('invitation_template_id', $template->id)
            ->where('status', 'paid')
            ->exists();
    }

    public static function price(InvitationTemplate $template): string
    {
        return '₱' . number_format(((int) $template->premium_price_cents) / 100, 2);
    }

    public static function isAvailable(): bool
    {
        return filled(config('services.stripe.secret'))
            && filled(config('services.stripe.webhook_secret'));
    }

    /**
     * Fields that may not appear in the free fine-tune editor. Basic ceremony
     * date, time, name and address remain free; extended ceremony and maps do not.
     */
    public static function lockedField(string $key): bool
    {
        return in_array($key, [
            'ceremony_type', 'ceremony_notes', 'unplugged_note',
            'ceremony_map_url', 'reception_map_url', 'venue_map_url',
            'map_heading', 'map_intro', 'ceremony_program',
            'reception_program', 'video_embed_url', 'video_heading', 'video_message',
        ], true) || str_ends_with($key, '_map_url');
    }

    public static function lockedGroup(string $group): bool
    {
        return in_array($group, ['guests', 'program', 'entourage', 'video'], true);
    }

    public static function filterSections(array $sections, bool $hasAccess): array
    {
        if ($hasAccess) return $sections;
        foreach (['entourage', 'program', 'guests', 'video', 'maps', 'ceremony_details'] as $key) {
            $sections[$key] = false;
        }
        return $sections;
    }

    public static function stripPremiumAnswers(array $answers): array
    {
        foreach ([
            'ceremony_program','reception_program','ceremony_notes','ceremony_type',
            'unplugged_note', 'map_heading', 'map_intro',
            'ceremony_map_url','reception_map_url','venue_map_url',
            'video_embed_url','video_heading','video_message',
        ] as $key) {
            unset($answers[$key]);
        }
        return $answers;
    }
}
