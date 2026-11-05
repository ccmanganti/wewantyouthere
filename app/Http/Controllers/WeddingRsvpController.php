<?php

namespace App\Http\Controllers;

use App\Models\InvitationWebsite;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class WeddingRsvpController extends Controller
{
    public function store(Request $request, string $slug): RedirectResponse
    {
        $website = InvitationWebsite::query()->where('slug', $slug)
            ->where('status', 'published')->firstOrFail();

        $answers = $website->answers ?? [];
        if (filled($answers['rsvp_deadline'] ?? null)) {
            try {
                if (CarbonImmutable::parse($answers['rsvp_deadline'])->endOfDay()->isPast()) {
                    throw ValidationException::withMessages(['attendance' => 'RSVPs for this wedding have closed. Please contact the couple.']);
                }
            } catch (ValidationException $e) {
                throw $e;
            } catch (\Throwable $e) {
                // An invalid stored date must not prevent guest response.
            }
        }

        // Per-invitation allowance, never a global headcount or paid seat limit.
        $maximum = max(1, min(12, (int) ($answers['guest_limit'] ?? 3)));
        $data = $request->validate([
            'guest_name' => ['required','string','min:2','max:120'],
            'attendance' => ['required',Rule::in(['attending','declined'])],
            'party_size' => ['nullable','integer','min:1','max:'.$maximum],
            'message' => ['nullable','string','max:500'],
            'website' => ['nullable','size:0'], // honeypot
        ]);

        if ($data['attendance'] === 'attending' && empty($data['party_size'])) {
            throw ValidationException::withMessages(['party_size' => 'Select how many guests will attend, including you.']);
        }

        $website->rsvps()->create([
            'guest_name' => trim($data['guest_name']),
            'attendance' => $data['attendance'],
            'guest_count' => $data['attendance'] === 'declined' ? 0 : (int) $data['party_size'],
            'message' => trim($data['message'] ?? '') ?: null,
        ]);

        return redirect()->route('wedding.show', $website->slug)
            ->with('rsvp_success', $data['attendance'] === 'attending'
                ? 'Thank you! Your attendance has been recorded.'
                : 'Thank you for letting us know. Your response has been recorded.');
    }

    public function manage(Request $request, InvitationWebsite $website): View
    {
        abort_unless((int) $website->user_id === (int) $request->user()->id, 403);

        return view('weddings.rsvps.index', [
            'website' => $website,
            'responses' => $website->rsvps()->latest()->paginate(25),
            'attending' => $website->rsvps()->where('attendance', 'attending')->sum('guest_count'),
            'declined' => $website->rsvps()->where('attendance', 'declined')->count(),
        ]);
    }
}
