<?php

namespace App\Http\Controllers;

use App\Models\InvitationTemplate;
use App\Models\InvitationWebsite;
use App\Support\InvitationAccounts;
use App\Support\InvitationPremium;
use App\Support\WeddingAudio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WeddingAudioController extends Controller
{
    private function template(Request $request, string $slug): InvitationTemplate
    {
        $template = InvitationTemplate::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where('settings->renderer', 'builtin_wedding')
            ->firstOrFail();

        abort_unless(WeddingAudio::supported($template)
            && InvitationPremium::has($request->user(), $template), 403);

        return $template;
    }

    private function entryResponse(array $entry, string $slot): BinaryFileResponse
    {
        $mimes = config('wedding_audio.uploads.mimes', []);
        abort_unless(isset($entry['path'], $entry['mime'])
            && isset($mimes[$entry['mime']])
            && Storage::disk('local')->exists($entry['path']), 404);

        $headers = [
            'Content-Type' => $entry['mime'],
            'Content-Disposition' => 'inline; filename="wedding-'.$slot.'.'.$mimes[$entry['mime']].'"',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, max-age=300',
        ];
        return response()->file(Storage::disk('local')->path($entry['path']), $headers);
    }

    public function upload(Request $request, string $slug): JsonResponse
    {
        $template = $this->template($request, $slug);
        abort_unless(InvitationAccounts::canCreateWebsite($request->user()), 403);
        $mimes = config('wedding_audio.uploads.mimes', []);
        $data = $request->validate([
            'slot' => ['required', Rule::in(WeddingAudio::SLOTS)],
            'audio' => ['required','file','mimetypes:'.implode(',', array_keys($mimes)),
                'max:'.config('wedding_audio.uploads.max_kb', 12288)],
        ]);
        $slot = $data['slot'];
        $file = $data['audio'];
        $mime = $file->getMimeType();
        abort_unless(isset($mimes[$mime]), 422);

        $key = 'wedding_audio_uploads.'.$template->id;
        $existing = $request->session()->get($key, []);
        $path = 'wedding-audio-drafts/'.hash('sha256', $request->session()->getId())
            .'/'.$request->user()->id.'/'.$template->id.'/'.Str::random(36).'.'.$mimes[$mime];
        abort_unless(Storage::disk('local')->putFileAs(dirname($path), $file, basename($path)), 503);

        if (isset($existing[$slot]['path'])) Storage::disk('local')->delete($existing[$slot]['path']);
        $existing[$slot] = ['path' => $path, 'mime' => $mime, 'name' => Str::limit(basename($file->getClientOriginalName()), 90, '')];
        $request->session()->put($key, $existing);

        return response()->json([
            'slot' => $slot,
            'name' => $existing[$slot]['name'],
            'url' => route('wedding.audio.draft', ['slug' => $template->slug, 'slot' => $slot]).'?v='.Str::random(8),
            'message' => 'Custom music uploaded and saved privately.',
        ]);
    }

    public function draft(Request $request, string $slug, string $slot): BinaryFileResponse
    {
        $template = $this->template($request, $slug);
        abort_unless(in_array($slot, WeddingAudio::SLOTS, true), 404);
        $entry = $request->session()->get('wedding_audio_uploads.'.$template->id.'.'.$slot, []);
        // Laravel can regenerate its session identifier between requests.
        // The authenticated owner's session already owns this manifest entry;
        // validate its stable owner/template path, not a rehashed session ID.
        $path = is_array($entry) ? ($entry['path'] ?? '') : '';
        abort_unless(is_string($path)
            && preg_match('/\\Awedding-audio-drafts\\/[a-f0-9]{64}\\/'
                .$request->user()->id.'\\/'.$template->id.'\\/[A-Za-z0-9]{36}\\.(mp3|wav|ogg|m4a)\\z/', $path), 404);
        return $this->entryResponse($entry, $slot);
    }

    public function remove(Request $request, string $slug, string $slot): JsonResponse
    {
        $template = $this->template($request, $slug);
        abort_unless(in_array($slot, WeddingAudio::SLOTS, true), 404);
        $key = 'wedding_audio_uploads.'.$template->id;
        $entries = $request->session()->get($key, []);
        if (isset($entries[$slot]['path'])) Storage::disk('local')->delete($entries[$slot]['path']);
        unset($entries[$slot]);
        $request->session()->put($key, $entries);
        return response()->json(['slot' => $slot, 'removed' => true]);
    }

    private function ownedWebsite(Request $request, InvitationWebsite $website): InvitationWebsite
    {
        abort_unless((int) $website->user_id === (int) $request->user()->id, 403);
        $website->loadMissing('template');
        abort_unless($website->template && WeddingAudio::supported($website->template)
            && InvitationPremium::has($request->user(), $website->template), 403);
        return $website;
    }

    public function manage(Request $request, InvitationWebsite $website): View
    {
        $website = $this->ownedWebsite($request, $website);
        $settings = WeddingAudio::forForm($website->template, [
            'audio' => ($website->answers ?? [])['_audio'] ?? [],
        ]);
        return view('weddings.audio.manage', [
            'website' => $website,
            'template' => $website->template,
            'musicSettings' => $settings,
            'existingAudio' => $website->media ?? [],
        ]);
    }

    public function update(Request $request, InvitationWebsite $website): RedirectResponse
    {
        $website = $this->ownedWebsite($request, $website);
        $allowedMime = config('wedding_audio.uploads.mimes', []);
        $request->validate([
            'audio' => ['nullable','array'],
            'music_files' => ['nullable','array'],
            'music_files.intro' => ['nullable','file','mimetypes:'.implode(',',array_keys($allowedMime)),
                'max:'.config('wedding_audio.uploads.max_kb',12288)],
            'music_files.main' => ['nullable','file','mimetypes:'.implode(',',array_keys($allowedMime)),
                'max:'.config('wedding_audio.uploads.max_kb',12288)],
        ]);
        $settings = WeddingAudio::fromRequest($request, $website->template, true, $website);
        $media = $website->media ?? [];
        $created = [];
        $replaced = [];
        try {
            foreach (WeddingAudio::SLOTS as $slot) {
                $file = $request->file('music_files.'.$slot);
                if (!$file) continue;
                $mime = $file->getMimeType();
                $extension = $allowedMime[$mime] ?? null;
                abort_unless($extension, 422);
                $destination = 'wedding-sites/'.$website->id.'/audio/'.$slot.'-'.Str::random(14).'.'.$extension;
                if (!Storage::disk('local')->putFileAs(dirname($destination), $file, basename($destination))) {
                    throw new \RuntimeException('Could not save your music. Please try again.');
                }
                $created[] = $destination;
                $existing = ($media['audio_'.$slot] ?? [])['path'] ?? null;
                if ($existing && str_starts_with($existing,'wedding-sites/'.$website->id.'/audio/')) {
                    $replaced[] = $existing;
                }
                $media['audio_'.$slot] = ['path'=>$destination,'mime'=>$mime];
            }
            $answers = $website->answers ?? [];
            $answers['_audio'] = $settings;
            $website->update(['answers'=>$answers,'media'=>$media]);
        } catch (\Throwable $error) {
            foreach ($created as $path) Storage::disk('local')->delete($path);
            throw $error;
        }
        foreach ($replaced as $oldPath) Storage::disk('local')->delete($oldPath);

        return redirect()->route('wedding.audio.manage', $website)
            ->with('status','Your invitation soundtrack has been updated.');
    }

    public function ownerPreview(Request $request, InvitationWebsite $website, string $slot): BinaryFileResponse
    {
        $website = $this->ownedWebsite($request,$website);
        abort_unless(in_array($slot,WeddingAudio::SLOTS,true),404);
        $entry = ($website->media ?? [])['audio_'.$slot] ?? [];
        abort_unless(is_array($entry)
            && str_starts_with($entry['path'] ?? '','wedding-sites/'.$website->id.'/audio/'),404);
        return $this->entryResponse($entry, $slot);
    }

    public function publicAudio(string $slug, string $slot): BinaryFileResponse
    {
        abort_unless(in_array($slot, WeddingAudio::SLOTS, true), 404);
        $website = InvitationWebsite::with('template','user')->where('slug', $slug)
            ->where('status', 'published')->firstOrFail();
        abort_unless($website->template && InvitationPremium::has($website->user, $website->template), 404);
        $settings = WeddingAudio::publicSettings($website, $website->template, true);
        abort_unless(($settings[$slot]['source'] ?? 'none') === 'custom', 404);
        $entry = ($website->media ?? [])['audio_'.$slot] ?? [];
        abort_unless(is_array($entry) && str_starts_with($entry['path'] ?? '',
            'wedding-sites/'.$website->id.'/audio/'), 404);

        return $this->entryResponse($entry, $slot);
    }
}
