<?php

namespace App\Support;

use App\Models\InvitationTemplate;

/**
 * Stable, immutable identity of each curated design.
 *
 * Database settings are editable and can be stale after a deployment.
 * Never silently fall back to another theme: a template's canonical slug
 * decides which layout, stylesheet, intro, animation and sample gallery render.
 */
final class CuratedWeddingDesign
{
    public const REVISION = 4;

    public static function forTemplate(?InvitationTemplate $template): ?string
    {
        if ($template === null) {
            return null;
        }

        foreach (config('wedding_curated_themes', []) as $key => $design) {
            if (($design['slug'] ?? '') === $template->slug) {
                return (string) $key;
            }
        }

        return null;
    }

    public static function isCurated(?InvitationTemplate $template): bool
    {
        return self::forTemplate($template) !== null;
    }

    public static function isSpecialEditor(?InvitationTemplate $template): bool
    {
        return self::isCurated($template)
            || (($template?->settings['theme'] ?? '') === 'royal_burgundy');
    }

    public static function photoSlots(?InvitationTemplate $template): array
    {
        $slots = config('wedding_photos', []);
        $key = self::forTemplate($template);
        if ($key === null) {
            return $slots;
        }

        // Only show upload slots that physically exist in this design.
        $enabled = array_keys(config('wedding_curated_assets.'.$key.'.photos', []));

        return array_intersect_key($slots, array_fill_keys($enabled, true));
    }
}
