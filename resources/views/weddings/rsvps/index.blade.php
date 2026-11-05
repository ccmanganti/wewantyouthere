@extends('layouts.wwyt')
@section('title','Guest RSVPs | We Want You There')
@section('robots','noindex,nofollow')

@push('styles')
<style>
.wwyt-responses{max-width:1080px;padding:45px 22px 100px;margin:0 auto;font:14px/1.5 'DM Sans',Arial,sans-serif}
.wwyt-responses h1{font:400 clamp(36px,5vw,60px) Georgia,serif;margin:10px 0;color:#630000}
.wwyt-responses>p{color:#655754;max-width:650px}
.wwyt-response-actions{margin:22px 0}.wwyt-response-actions a{color:#810100;font-weight:700}
.wwyt-response-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin:24px 0}
.wwyt-response-stats>div{padding:20px;border:1px solid #e3d4c8;border-radius:12px;background:#fff}
.wwyt-response-stats strong{display:block;font:500 36px Georgia,serif;color:#6f101a}
.wwyt-response-stats span{font-size:12px;color:#695956}
.wwyt-response-table{overflow-x:auto;background:#fff;border:1px solid #e1cfc2;border-radius:12px}
.wwyt-response-table table{border-collapse:collapse;min-width:690px;width:100%}
.wwyt-response-table td,.wwyt-response-table th{text-align:left;border-bottom:1px solid #e7d9cd;padding:15px}
.wwyt-response-table th{font-size:11px;text-transform:uppercase;color:#83645c;letter-spacing:.08em;background:#fcf6ec}
.wwyt-response-table td{font-size:13px;vertical-align:top}
.wwyt-response-table .answer{white-space:pre-wrap;max-width:320px}
.wwyt-response-empty{padding:35px;text-align:center;color:#7b6961}
@media(max-width:620px){.wwyt-responses{padding:23px 14px 70px}.wwyt-response-stats{gap:6px}.wwyt-response-stats>div{padding:12px}.wwyt-response-stats strong{font-size:26px}.wwyt-response-stats span{font-size:10px}}
</style>
@endpush

@section('content')
<main class="wwyt-responses">
    <span style="font-size:11px;letter-spacing:.18em;color:#810100">YOUR INVITATION / GUEST LIST</span>
    <h1>Guest responses</h1>
    <p>{{ $website->name }} · View attendance confirmations and personal messages submitted through your published website.</p>
    <div class="wwyt-response-actions"><a href="/app/invitations">← Back to My Invitations</a></div>
    <div class="wwyt-response-stats">
        <div><strong>{{ $responses->total() }}</strong><span>Responses</span></div>
        <div><strong>{{ $attending }}</strong><span>Attending guests</span></div>
        <div><strong>{{ $declined }}</strong><span>Declined</span></div>
    </div>
    <div class="wwyt-response-table">
        @if($responses->count())
            <table>
                <thead><tr><th>Guest</th><th>Response</th><th>Party size</th><th>Message</th><th>Received</th></tr></thead>
                <tbody>
                    @foreach($responses as $response)
                        <tr>
                            <td><strong>{{ $response->guest_name }}</strong></td>
                            <td>{{ $response->attendance === 'attending' ? 'Attending' : 'Declined' }}</td>
                            <td>{{ $response->guest_count }}</td>
                            <td class="answer">{{ $response->message ?: '—' }}</td>
                            <td>{{ $response->created_at?->format('M j, Y g:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="wwyt-response-empty">No responses yet. Guests can reply using the RSVP form on your invitation website.</div>
        @endif
    </div>
    <div style="margin-top:18px">{{ $responses->links() }}</div>
</main>
@endsection
