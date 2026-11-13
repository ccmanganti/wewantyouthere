<?php

namespace App\Http\Controllers;

use App\Models\InvitationTemplate;
use App\Support\InvitationAccounts;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function templates(): View
    {
        $templates = $this->publicTemplates()->get();

        return view('marketing.templates', [
            'templates' => $templates,
            'canCreate' => ! Auth::check() || InvitationAccounts::canCreateWebsite(Auth::user()),
        ]);
    }

    public function templateDetail(string $slug): View
    {
        $template = $this->publicTemplates()->where('slug', $slug)->firstOrFail();

        return view('marketing.template-detail', [
            'template' => $template,
            'canCreate' => ! Auth::check() || InvitationAccounts::canCreateWebsite(Auth::user()),
        ]);
    }

    public function templatePreview(string $slug): View
    {
        $template = $this->publicTemplates()->where('slug', $slug)->firstOrFail();

        $answers = [
            'bride_name' => 'Amelia',
            'groom_name' => 'Gabriel',
            'event_title' => 'Our wedding celebration',
            'event_date' => '2027-12-12',
            'event_time' => '15:00',
            'venue_name' => 'The Glass Garden',
            'ceremony_venue' => 'The Glass Chapel',
            'ceremony_address' => 'A beautiful garden in the Philippines',
            'reception_venue' => 'The Glass Garden',
            'reception_time' => '18:00',
            'host_message' => 'With joyful hearts, we invite you to celebrate the beginning of our forever.',
            'principal_sponsors' => 'Our dear Ninongs and Ninangs',
            'best_man' => 'Daniel',
            'maid_of_honor' => 'Isabella',
            'groomsmen' => 'Our closest friends',
            'bridesmaids' => 'Our dearest friends',
            'event_schedule' => "2:00 PM — Guest arrival\n3:00 PM — Wedding ceremony\n6:00 PM — Reception",
            'dress_code' => 'Formal garden attire',
            'color_motif' => 'Ivory, sage green and champagne',
            'rsvp_deadline' => '2027-11-20',
            'rsvp_message' => 'Your presence means the world to us.',
            'gift_message' => 'Your presence is the greatest gift of all.',
        ];

        // Each theme advertises a different sample wedding. No published
        // invitation receives these showcase details.
        if ($key = \App\Support\CuratedWeddingDesign::forTemplate($template)) {
            $answers = array_replace($answers, config('wedding_curated_showcases.'.$key, []));
        }

        return view('marketing.template-preview', [
            'template' => $template,
            'answers' => $answers,
            'sections' => [
                'couple' => true,
                'ceremony' => true,
                'reception' => true,
                'entourage' => true,
                'program' => true,
                'guests' => true,
                'details' => true,
                'maps' => true,
                'ceremony_details' => true,
                'video' => false,
            ],
            'questions' => $template->eventType->questions()
                ->where('is_enabled', true)->orderBy('sort_order')->get()->groupBy('group_key'),
        ]);
    }

    public function legal(string $section): View
    {
        abort_unless(in_array($section, ['privacy', 'terms'], true), 404);

        return view('marketing.legal', ['section' => $section]);
    }

    public function sitemap(): Response
    {
        $base = rtrim(config('app.url'), '/');
        $paths = ['/', '/wedding-invitation-templates', '/privacy', '/terms'];

        foreach ($this->publicTemplates()->pluck('slug') as $slug) {
            $paths[] = '/wedding-invitation-templates/' . rawurlencode($slug);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($paths as $path) {
            $xml .= '<url><loc>' . htmlspecialchars($base . $path, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</loc></url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    public function robots(): Response
    {
        $base = rtrim(config('app.url'), '/');

        return response(
            "User-agent: *\n"
            . "Disallow: /admin/\nDisallow: /app/\nDisallow: /auth/google/\n"
            . "Sitemap: {$base}/sitemap.xml\n",
            200,
            ['Content-Type' => 'text/plain; charset=UTF-8'],
        );
    }

    private function publicTemplates(): \Illuminate\Database\Eloquent\Builder
    {
        return InvitationTemplate::query()
            ->with('eventType')
            ->where('status', 'published')
            ->where('settings->renderer', 'builtin_wedding')
            ->whereHas('eventType', fn ($query) => $query->where('slug', 'wedding')->where('is_active', true))
            ->orderBy('name');
    }
}
