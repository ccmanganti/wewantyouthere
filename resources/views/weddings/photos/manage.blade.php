@extends('layouts.wwyt')
@section('title','Manage Wedding Photos | We Want You There')
@section('robots','noindex,nofollow')

@push('styles')
<style>
.photo-manager{max-width:1180px;margin:0 auto;padding:45px 24px 90px;font-family:'DM Sans',Arial,sans-serif}
.photo-manager .eyebrow{font-size:10px;letter-spacing:.18em;color:#810100;text-transform:uppercase;font-weight:800}
.photo-manager .heading{font-family:Georgia,serif;font-weight:400;font-size:clamp(32px,4vw,58px);letter-spacing:-.05em;margin:10px 0;color:#1B1717}
.photo-manager .lead{max-width:760px;line-height:1.75;color:#786b66;font-size:13px}
.photo-manager .actions{display:flex;gap:12px;flex-wrap:wrap;margin:23px 0 32px}
.photo-manager .actions a{padding:12px 16px;font-size:12px;font-weight:800;border:1px solid #baafa4;border-radius:8px;color:#630000;text-decoration:none}
.photo-manager .actions a:first-child{background:#810100;color:#fff;border-color:#810100}
.photo-manager .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(255px,1fr));gap:18px}
.photo-manager .card{background:#fffdf8;border:1px solid #ddcbbd;border-radius:14px;overflow:hidden}
.photo-manager .preview{height:190px;background:linear-gradient(135deg,#e8d6c4,#bf9e96);display:grid;place-items:center;overflow:hidden}
.photo-manager .preview img{width:100%;height:100%;object-fit:cover}
.photo-manager .empty{color:#7e5153;font-size:13px;font-weight:700}
.photo-manager .body{padding:18px}
.photo-manager .body strong{display:block;font:400 25px Georgia,serif;color:#2b2020}
.photo-manager .body p{font-size:11px;line-height:1.6;color:#897771;margin:8px 0 15px;min-height:30px}
.photo-manager .upload{display:block;position:relative;font-size:11px;color:#63534d}
.photo-manager .upload input{width:100%;max-width:100%;font-size:11px;margin:9px 0}
.photo-manager .upload button{background:#810100;color:#fff;border:none;border-radius:7px;padding:10px 15px;cursor:pointer;font-size:12px;font-weight:800;min-height:42px}
.photo-manager .remove{margin-top:11px}
.photo-manager .remove button{background:transparent;border:1px solid #d1beb0;border-radius:7px;padding:9px 15px;color:#8a1d24;cursor:pointer;font-size:11px}
.photo-manager .notice{border:1px solid #d1bba6;background:#f7e8da;padding:12px 15px;margin:18px 0;font-size:12px;border-radius:8px;color:#602828}
@media(max-width:630px){.photo-manager{padding:25px 14px 60px}.photo-manager .grid{grid-template-columns:1fr 1fr;gap:10px}.photo-manager .preview{height:142px}.photo-manager .body{padding:12px}.photo-manager .body strong{font-size:19px}}
@media(max-width:450px){.photo-manager .grid{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
<main class="photo-manager">
    <span class="eyebrow">MY INVITATION / PHOTO STUDIO</span>
    <h1 class="heading">Your photographs, your story.</h1>
    <p class="lead">Choose where each photo belongs in <strong>{{ $website->name }}</strong>. Replacing a photograph updates the public invitation without changing its link or QR code. Photos are stored privately and served only with the invitation.</p>
    <div class="actions">
        <a href="{{ url('/app/invitations') }}">← Back to My Invitations</a>
        @if($website->status === 'published')<a href="{{ route('wedding.show', $website->slug) }}" target="_blank" rel="noopener">View my website ↗</a>@endif
    </div>

    @if(session('status'))<div class="notice" role="status">{{ session('status') }}</div>@endif
    @if($errors->any())<div class="notice" role="alert">{{ $errors->first() }}</div>@endif

    <div class="grid">
        @foreach($slots as $slot => $definition)
        @php $hasImage = isset(($website->media ?? [])[$slot]); @endphp
        <article class="card">
            <div class="preview">
                @if($hasImage)
                    <img src="{{ route('wedding.photos.site', ['slug' => $website->slug, 'slot' => $slot]) }}?v={{ $website->updated_at?->timestamp }}" alt="{{ $definition['label'] }}" loading="lazy">
                @else
                    <div class="empty"><i class="fa-solid fa-image" aria-hidden="true"></i> No photo yet</div>
                @endif
            </div>
            <div class="body">
                <strong>{{ $definition['label'] }}</strong>
                <p>{{ $definition['hint'] }}</p>
                <form method="POST" enctype="multipart/form-data" action="{{ route('wedding.photos.replace', $website) }}">
                    @csrf
                    <input type="hidden" name="slot" value="{{ $slot }}">
                    <label class="upload">{{ $hasImage ? 'Replace photo' : 'Upload a photo' }}
                        <input type="file" name="photo" accept="image/png,image/jpeg,image/webp" required>
                        <button type="submit"><i class="fa-solid fa-camera" aria-hidden="true"></i> Save photo</button>
                    </label>
                </form>
                @if($hasImage)
                    <form class="remove" method="POST" action="{{ route('wedding.photos.remove', ['website' => $website, 'slot' => $slot]) }}">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Remove this photograph from the invitation?')">Remove photo</button>
                    </form>
                @endif
            </div>
        </article>
        @endforeach
    </div>
    <p class="lead" style="margin-top:25px">Accepted: JPEG, PNG and WebP, up to 5 MB and 6000 × 6000 pixels. Uploaded media is not accessible through the public file directory.</p>
</main>
@endsection