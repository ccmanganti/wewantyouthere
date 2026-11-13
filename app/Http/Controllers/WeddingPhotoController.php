<?php

namespace App\Http\Controllers;

use App\Models\InvitationTemplate;
use App\Models\InvitationWebsite;
use App\Support\InvitationAccounts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WeddingPhotoController extends Controller
{
    private function template(string $slug): InvitationTemplate
    {
        return InvitationTemplate::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where('settings->renderer', 'builtin_wedding')
            ->where(function ($query) {
                $query->where('settings->theme', 'royal_burgundy')
                    ->orWhereIn('slug', array_values(array_column(config('wedding_curated_themes', []), 'slug')));
            })
            ->firstOrFail();
    }

    private function validSlot(string $slot): void
    {
        abort_unless(array_key_exists($slot, config('wedding_photos', [])), 404);
    }

    private function validatePhoto(Request $request): array
    {
        return $request->validate([
            'slot' => ['required', 'string', Rule::in(array_keys(config('wedding_photos', [])))],
            'photo' => ['required', 'file', 'image', 'mimetypes:image/jpeg,image/png,image/webp', 'max:5120', 'dimensions:max_width=6000,max_height=6000'],
        ]);
    }

    /**
     * Browser-session scoped private upload. Files are never served from public_html.
     * CSRF + throttling + slot allowlist prevents arbitrary file writes.
     */
    public function upload(Request $request, string $slug): JsonResponse
    {
        $template = $this->template($slug);
        abort_if($request->user() && ! InvitationAccounts::canCreateWebsite($request->user()), 403);
        $this->validatePhoto($request);
        $slot = $request->string('slot')->toString();
        abort_unless(array_key_exists($slot, \App\Support\CuratedWeddingDesign::photoSlots($template)), 422);
        $file = $request->file('photo');

        $mime = $file->getMimeType();
        $extension = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$mime] ?? null;
        abort_unless($extension, 422);

        $key = 'wedding_uploads.' . $template->id;
        $existing = $request->session()->get($key, []);
        $relative = 'wedding-drafts/' . hash('sha256', $request->session()->getId())
            . '/' . $template->id . '/' . Str::random(36) . '.' . $extension;
        abort_unless(Storage::disk('local')->putFileAs(dirname($relative), $file, basename($relative)), 503);
        if (isset($existing[$slot]['path'])) {
            Storage::disk('local')->delete($existing[$slot]['path']);
        }
        $existing[$slot] = ['path' => $relative, 'mime' => $mime];
        $request->session()->put($key, $existing);

        return response()->json([
            'slot' => $slot,
            'url' => route('wedding.photos.draft', ['slug' => $slug, 'slot' => $slot]) . '?v=' . Str::random(8),
            'message' => 'Photo saved. It will appear on your published invitation.',
        ]);
    }

    public function draft(Request $request, string $slug, string $slot): BinaryFileResponse
    {
        $template = $this->template($slug);
        $this->validSlot($slot);
        abort_unless(array_key_exists($slot, \App\Support\CuratedWeddingDesign::photoSlots($template)), 404);
        $entry = $request->session()->get('wedding_uploads.' . $template->id . '.' . $slot);
        abort_unless(is_array($entry) && isset($entry['path'], $entry['mime'])
            && Storage::disk('local')->exists($entry['path']), 404);

        return $this->privateImage($entry);
    }

    public function removeDraft(Request $request, string $slug, string $slot): JsonResponse
    {
        $template = $this->template($slug);
        $this->validSlot($slot);
        abort_unless(array_key_exists($slot, \App\Support\CuratedWeddingDesign::photoSlots($template)), 404);
        $key = 'wedding_uploads.' . $template->id;
        $existing = $request->session()->get($key, []);
        if (isset($existing[$slot]['path'])) {
            Storage::disk('local')->delete($existing[$slot]['path']);
        }
        unset($existing[$slot]);
        $request->session()->put($key, $existing);

        return response()->json(['slot' => $slot, 'removed' => true]);
    }

    public function publicPhoto(string $slug, string $slot): BinaryFileResponse
    {
        $this->validSlot($slot);
        $website = InvitationWebsite::query()->where('slug', $slug)->firstOrFail();
        abort_unless($website->status === 'published'
            || (auth()->check() && (int) auth()->id() === (int) $website->user_id), 404);
        $entry = ($website->media ?? [])[$slot] ?? null;
        abort_unless(is_array($entry) && isset($entry['path'], $entry['mime'])
            && str_starts_with($entry['path'], 'wedding-sites/' . $website->id . '/')
            && Storage::disk('local')->exists($entry['path']), 404);

        return $this->privateImage($entry, true);
    }

    public function manage(Request $request, InvitationWebsite $website): View
    {
        abort_unless((int) $website->user_id === (int) $request->user()->id, 403);

        return view('weddings.photos.manage', [
            'website' => $website,
            'slots' => config('wedding_photos', []),
        ]);
    }

    public function replace(Request $request, InvitationWebsite $website): RedirectResponse
    {
        abort_unless((int) $website->user_id === (int) $request->user()->id, 403);
        $this->validatePhoto($request);
        $slot = $request->string('slot')->toString();
        $file = $request->file('photo');
        $mime = $file->getMimeType();
        $extension = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$mime] ?? null;
        abort_unless($extension, 422);

        $manifest = $website->media ?? [];
        $old = $manifest[$slot]['path'] ?? null;
        $path = 'wedding-sites/' . $website->id . '/' . $slot . '-' . Str::random(10) . '.' . $extension;
        abort_unless(Storage::disk('local')->putFileAs(dirname($path), $file, basename($path)), 503);
        $manifest[$slot] = ['path' => $path, 'mime' => $mime];
        $website->update(['media' => $manifest]);
        if ($old) Storage::disk('local')->delete($old);

        return back()->with('status', 'Photo updated on your wedding website.');
    }

    public function remove(Request $request, InvitationWebsite $website, string $slot): RedirectResponse
    {
        abort_unless((int) $website->user_id === (int) $request->user()->id, 403);
        $this->validSlot($slot);
        $manifest = $website->media ?? [];
        $old = $manifest[$slot]['path'] ?? null;
        unset($manifest[$slot]);
        $website->update(['media' => $manifest]);
        if ($old) Storage::disk('local')->delete($old);

        return back()->with('status', 'Photo removed from your invitation.');
    }

    private function privateImage(array $entry, bool $published = false): BinaryFileResponse
    {
        // Paths are generated internally, never supplied by request parameters.
        abort_unless(str_starts_with($entry['path'], $published ? 'wedding-sites/' : 'wedding-drafts/'), 404);
        abort_unless(in_array($entry['mime'], ['image/jpeg', 'image/png', 'image/webp'], true), 404);

        return response()->file(Storage::disk('local')->path($entry['path']), [
            'Content-Type' => $entry['mime'],
            'Content-Disposition' => 'inline',
            'X-Content-Type-Options' => 'nosniff',
            'X-Robots-Tag' => 'noindex',
            'Cache-Control' => $published ? 'public, max-age=3600' : 'private, no-store',
        ]);
    }
}
