<?php

namespace App\Support;

use App\Models\InvitationTemplate;
use App\Models\InvitationWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

final class WeddingAudio
{
    public const SLOTS = ['intro', 'main'];

    public static function supported(InvitationTemplate $template): bool
    {
        return CuratedWeddingDesign::isCurated($template)
            || ($template->settings['theme'] ?? '') === 'royal_burgundy';
    }

    public static function defaults(InvitationTemplate $template): array
    {
        $key = CuratedWeddingDesign::forTemplate($template) ?? 'royal_burgundy';
        $tracks = config('wedding_audio.defaults.'.$key, []);
        return [
            'intro' => ['source' => 'library', 'track' => $tracks['intro'] ?? ''],
            'main' => ['source' => 'library', 'track' => $tracks['main'] ?? ''],
            'sfx' => true,
            'volume' => 45,
        ];
    }

    public static function forForm(InvitationTemplate $template, array $draft = []): array
    {
        $defaults = self::defaults($template);
        $saved = $draft['audio'] ?? [];
        if (!is_array($saved)) return $defaults;
        foreach (self::SLOTS as $slot) {
            if (is_array($saved[$slot] ?? null)) {
                $defaults[$slot] = array_merge($defaults[$slot], $saved[$slot]);
            }
        }
        $defaults['sfx'] = (bool) ($saved['sfx'] ?? $defaults['sfx']);
        $defaults['volume'] = (int) ($saved['volume'] ?? 45);
        return $defaults;
    }

    /**
     * Never trust posted premium data without a paid entitlement. Custom track
     * selection must refer to an actual owner-scoped private session upload.
     */
    public static function fromRequest(Request $request, InvitationTemplate $template, bool $premium): array
    {
        if (!$premium || !self::supported($template)) return [];
        $input = $request->input('audio', []);
        if (!is_array($input)) $input = [];
        $defaults = self::defaults($template);
        $result = [];
        foreach (self::SLOTS as $slot) {
            $selection = $input[$slot] ?? $defaults[$slot];
            if (!is_array($selection)) $selection = [];
            $source = (string) ($selection['source'] ?? 'none');
            if (!in_array($source, ['none','library','custom'], true)) {
                throw ValidationException::withMessages(['audio' => 'Select a valid music source.']);
            }
            $track = '';
            if ($source === 'library') {
                $track = (string) ($selection['track'] ?? '');
                $entry = config('wedding_audio.tracks.'.$track);
                if (!is_array($entry) || ($entry['role'] ?? null) !== $slot) {
                    throw ValidationException::withMessages(['audio' => 'Choose a valid '.($slot === 'intro'?'opening':'website').' track.']);
                }
            }
            if ($source === 'custom') {
                $uploaded = $request->session()->get('wedding_audio_uploads.'.$template->id.'.'.$slot);
                if (!is_array($uploaded) || !isset($uploaded['path'], $uploaded['mime'])
                    || !Storage::disk('local')->exists($uploaded['path'])) {
                    throw ValidationException::withMessages(['audio' => 'Please upload the custom '.($slot === 'intro'?'opening':'website').' music before publishing.']);
                }
            }
            $result[$slot] = ['source' => $source, 'track' => $track];
        }
        $result['sfx'] = filter_var($input['sfx'] ?? true, FILTER_VALIDATE_BOOLEAN);
        $result['volume'] = max(0, min(100, (int) ($input['volume'] ?? 45)));
        return $result;
    }

    public static function publicSettings(?InvitationWebsite $website, InvitationTemplate $template, bool $premium): array
    {
        if (!$premium || !self::supported($template)) return ['enabled' => false];
        $raw = $website?->answers['_audio'] ?? [];
        if (!is_array($raw) || $raw === []) $raw = self::defaults($template);
        $result = ['enabled' => true, 'sfx' => (bool) ($raw['sfx'] ?? true), 'volume' => max(0, min(100, (int) ($raw['volume'] ?? 45)))];
        foreach (self::SLOTS as $slot) {
            $item = $raw[$slot] ?? [];
            $source = in_array($item['source'] ?? '', ['none','library','custom'], true) ? $item['source'] : 'none';
            $track = (string) ($item['track'] ?? '');
            $validTrack = config('wedding_audio.tracks.'.$track);
            $entry = ($website?->media ?? [])['audio_'.$slot] ?? [];
            if ($source === 'custom' && (!is_array($entry) || empty($entry['path']))) $source = 'none';
            if ($source === 'library' && (!is_array($validTrack) || ($validTrack['role'] ?? '') !== $slot)) $source = 'none';
            $result[$slot] = [
                'source' => $source,
                'track' => $source === 'library' ? $track : '',
                'url' => $source === 'custom' && $website
                    ? route('wedding.audio.site', ['slug' => $website->slug, 'slot' => $slot])
                    : null,
            ];
        }
        return $result;
    }
}
