@extends('layouts.wwyt')
@section('title', 'Customize Your Wedding Invitation | We Want You There')
@section('meta_description', 'Personalize your wedding website with a live preview. Add your ceremony, entourage, program, venue and guest details. Publish your free wedding invitation.')

@push('styles')
<style>
.builder-shell{width:min(1460px,calc(100% - 40px));margin:28px auto}
.builder-top{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:21px}
.builder-top h1{font-size:32px;margin:2px 0 0}
.builder-grid{display:grid;grid-template-columns:minmax(360px,.86fr) minmax(450px,1.14fr);gap:26px;align-items:start}
.panel{background:#fff;border:1px solid var(--line);border-radius:18px;overflow:hidden}
.panel-head{padding:23px 26px;border-bottom:1px solid var(--line)}
.panel-head h2{font-size:26px;margin:0 0 5px}.panel-head p{font-size:12px;color:var(--muted);margin:0}
.builder-form{max-height:calc(100vh - 230px);overflow-y:auto;overscroll-behavior:contain}
.group{border-bottom:1px solid var(--line)}
.group-head{display:flex;gap:12px;align-items:center;justify-content:space-between;padding:20px 23px}
.group-title{font-size:19px;font-family:'DM Serif Display',Georgia,serif;line-height:1.2}
.group-description{font-size:11px;color:var(--muted);margin-top:5px}
.group-fields{padding:0 23px 15px}
.group-fields textarea{min-height:88px;resize:vertical}
.group-fields input,.group-fields textarea{font-size:13px}
.group-fields .field-label{font-size:12px}
.group-toggle{display:flex;align-items:center;gap:7px;font-size:11px;color:#566e57;white-space:nowrap;cursor:pointer}
.group-toggle input{accent-color:var(--green);width:16px;height:16px}
.group-toggle span{font-weight:700}
.group-disabled .group-fields{display:none}
.form-footer{background:#fff;padding:18px 23px;border-top:1px solid var(--line);display:flex;justify-content:space-between;align-items:center;gap:10px}
.form-footer .btn{width:100%}
.preview-panel{position:sticky;top:18px}
.preview-head{padding:19px 23px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap}
.preview-head h2{font-size:23px;margin:0}
.preview-tabs{display:flex;gap:5px;border:1px solid var(--line);border-radius:10px;padding:4px;background:#f6f8f4;flex-wrap:wrap}
.preview-tab{padding:8px 12px;border:0;background:transparent;border-radius:8px;font-size:11px;font-weight:700;color:#637366}
.preview-tab[aria-selected=true]{background:#fff;color:var(--ink);box-shadow:0 1px 3px #00000010}
.preview-scroll{background:#e8ece5;padding:24px;max-height:calc(100vh - 270px);overflow:auto}
.preview-frame{max-width:580px;margin:auto;box-shadow:0 10px 35px #52635025;background:#fff}
.preview-status{border-top:1px solid var(--line);padding:14px 21px;color:var(--muted);font-size:11px;display:flex;gap:8px;align-items:center}
.preview-premium{min-height:460px;display:flex;align-items:center;justify-content:center;padding:30px}
.premium-placeholder{max-width:340px;text-align:center}.premium-placeholder .glyph{font-size:45px;display:block;margin-bottom:15px}
.premium-placeholder h3{font-size:30px;margin:0 0 10px}.premium-placeholder p{font-size:13px;color:var(--muted);line-height:1.7}
.upgrade-screen{display:none}.upgrade-screen.active{display:block}
.builder-stage.hidden{display:none}
.upgrade-head{padding:26px 28px}.upgrade-head h2{margin:0 0 8px;font-size:30px}.upgrade-head p{font-size:13px;color:var(--muted)}
.comparison{display:grid;grid-template-columns:1fr 1fr;gap:15px;padding:0 27px 25px}
.plan{border:1px solid #dfe3d9;border-radius:14px;padding:24px;background:#fff}
.plan-premium{border-color:#b7c8ba;background:#f4f7f1}
.plan h3{font-size:28px;margin:8px 0}.plan-price{font:32px 'DM Serif Display',Georgia,serif;color:var(--green)}
.plan ul{padding-left:18px;font-size:12px;line-height:2.1;color:#536356}
.upgrade-actions{display:flex;flex-wrap:wrap;gap:12px;padding:0 27px 26px;align-items:center}
.notice{font-size:12px;color:#7b6c50;background:#fcf8eb;border:1px solid #efe0be;border-radius:10px;padding:12px 16px;margin:12px 26px 24px}
.preview-comparison{display:grid;grid-template-columns:1fr 1fr;gap:14px;padding:16px;background:#e8ece5}
.comparison-mini{background:#fff;border:1px solid var(--line);border-radius:11px;overflow:hidden}.comparison-mini .mini-name{padding:14px;text-align:center;font-family:'DM Serif Display',serif;font-size:23px;background:#f7f4ec}.comparison-mini .mini-caption{padding:12px;font-size:11px;color:#687368}.comparison-mini.paid{border-color:#a5c5ab}
.wedding-invite{color:#5c5247;background:#fcf8f0;text-align:center;font-family:Georgia,serif}
.wedding-invite [hidden]{display:none!important}
.invite-cover{min-height:540px;position:relative;padding:80px 33px 65px;border:1px solid #e1dacd;display:flex;flex-direction:column;align-items:center;justify-content:center;overflow:hidden}
.ornament{position:absolute;font-size:135px;line-height:1;color:#b4c0a7;opacity:.6}.ornament-top{top:-55px;left:-30px;transform:rotate(-20deg)}.ornament-bottom{bottom:-55px;right:-30px;transform:rotate(145deg)}
.invite-eyebrow,.invite-small{font-family:'DM Sans',sans-serif;font-size:9px;letter-spacing:.19em;font-weight:600}.invite-divider{height:1px;width:78px;background:#c4b49c;margin:20px auto}
.invite-cover h1{font-family:'DM Serif Display',Georgia,serif;font-size:clamp(40px,4.4vw,64px);font-weight:400;line-height:1.15;color:#4b634d;margin:20px 0}.invite-cover h1 span{display:block}.invite-cover h1 i{display:block;font-size:.55em;font-weight:400}
.invite-message{font-style:italic;max-width:400px;line-height:1.8;font-size:14px}.invite-date{font-family:'DM Serif Display',Georgia,serif;font-size:23px;margin:0 0 10px}
.invite-section{padding:57px 35px;background:#fffdf8;border-top:1px solid #eae5d9}.invite-section h2{font-family:'DM Serif Display',Georgia,serif;font-size:35px;font-weight:400;color:#516b52;margin:14px 0 23px}.invite-section h3{font:600 10px 'DM Sans',sans-serif;letter-spacing:.14em;text-transform:uppercase;color:#66745f;margin:24px 0 11px}
.invite-section p{line-height:1.7;font-size:14px}.invite-tinted{background:#f0f1e9}.invite-two-cols{display:grid;grid-template-columns:1fr 1fr;gap:12px;padding-top:9px}.subtle{color:#888477;font-size:12px}.pre-line{white-space:pre-line}.invite-footer{padding:36px;font:italic 27px 'DM Serif Display',Georgia,serif}.invite-footer small{display:block;margin-top:13px;font:600 9px 'DM Sans',sans-serif;letter-spacing:.2em}
@media(max-width:1030px){.builder-grid{grid-template-columns:1fr}.builder-form{max-height:none}.preview-panel{position:static}.preview-scroll{max-height:640px}}
@media(max-width:600px){.builder-shell{width:calc(100% - 22px)}.panel-head,.group-head{padding:17px}.group-fields{padding:0 17px 14px}.preview-head{padding:15px}.preview-scroll{padding:12px;max-height:520px}.invite-cover{min-height:460px;padding:65px 22px}.invite-section{padding:42px 22px}.invite-two-cols,.comparison,.preview-comparison{grid-template-columns:1fr}.upgrade-head{padding:23px}.upgrade-actions{padding:0 22px 22px}.form-footer{padding:15px}}
</style>
@endpush

@section('content')
<div class="builder-shell">
    <div class="builder-top">
        <div><div class="eyebrow">Wedding · {{ $template->name }}</div><h1>Make it yours.</h1></div>
        <a class="btn btn-outline" href="{{ route('home') }}#templates">← Back to templates</a>
    </div>
    @if($errors->any())
        <div class="alert" role="alert" style="background:#fff1ee;border-color:#efc5bd;color:#9b433c">Please review the highlighted fields. {{ $errors->first() }}</div>
    @endif
    <form id="wedding-form" method="POST" action="{{ route('wedding.publish', $template->slug) }}">
        @csrf
        <div class="builder-grid">
            <div class="panel builder-stage" id="edit-stage">
                <div class="panel-head"><span class="eyebrow">Step 1 of 2 · Invitation details</span><h2>Your celebration, your way.</h2><p>Fill in what matters. Switch off sections you don't want to show. Your preview updates as you type.</p></div>
                <div class="builder-form" id="builder-fields">
                    @foreach($groups as $key => $group)
                        @php
                            $visible = ($draft['sections'][$key] ?? true);
                            $hideable = $group['hideable'] ?? true;
                        @endphp
                        <div class="group {{ !$visible ? 'group-disabled' : '' }}" data-group="{{ $key }}">
                            <div class="group-head">
                                <div><div class="group-title">{{ $group['title'] }}</div><div class="group-description">{{ $group['description'] }}</div></div>
                                @if($hideable)
                                    <label class="group-toggle"><input type="hidden" name="sections[{{ $key }}]" value="0"><input type="checkbox" name="sections[{{ $key }}]" value="1" data-section-toggle="{{ $key }}" {{ $visible ? 'checked' : '' }}> <span>Show</span></label>
                                @else
                                    <input type="hidden" name="sections[{{ $key }}]" value="1">
                                @endif
                            </div>
                            <div class="group-fields">
                                @foreach($group['questions'] as $question)
                                    @php($current = old('answers.'.$question->key, $draft['answers'][$question->key] ?? ''))
                                    <div class="field">
                                        <label class="field-label" for="question-{{ $question->id }}">{{ $question->label }} @if($question->is_required)<span class="danger">*</span>@endif</label>
                                        @if($question->type === 'textarea')
                                            <textarea id="question-{{ $question->id }}" name="answers[{{ $question->key }}]" rows="3" placeholder="{{ $question->placeholder }}" data-question="{{ $question->key }}" {{ $question->is_required && $visible ? 'required' : '' }}>{{ $current }}</textarea>
                                        @else
                                            <input id="question-{{ $question->id }}" name="answers[{{ $question->key }}]" type="{{ in_array($question->type, ['date','time','number','email','url']) ? $question->type : 'text' }}" placeholder="{{ $question->placeholder }}" value="{{ $current }}" data-question="{{ $question->key }}" {{ $question->is_required && $visible ? 'required' : '' }} @if($question->type === 'number') min="0" @endif>
                                        @endif
                                        @if($question->help_text)<div class="tiny muted">{{ $question->help_text }}</div>@endif
                                        @error('answers.'.$question->key)<div class="field-error">{{ $message }}</div>@enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-footer"><button type="button" id="choose-plan" class="btn">Continue to publishing →</button></div>
            </div>
            <div class="panel builder-stage upgrade-screen" id="upgrade-stage">
                <div class="upgrade-head"><span class="eyebrow">Step 2 of 2 · Publishing</span><h2>Ready to share your day?</h2><p>Your beautiful wedding website is free. Add-on features will be offered here as they become available.</p></div>
                <div class="comparison">
                    <div class="plan"><span class="pill">Available now</span><h3>Free wedding website</h3><div class="plan-price">₱0</div><ul><li>Your own shareable invitation link</li><li>Wedding details and entourage</li><li>Venue, dress code and program</li><li>Mobile-friendly website</li><li>We Want You There branding</li></ul></div>
                    <div class="plan plan-premium"><span class="pill">Coming soon</span><h3>Premium enhancements</h3><div class="plan-price">Pricing later</div><ul><li>Personalized QR invitations</li><li>Map links and enhanced directions</li><li>RSVP dashboard and notifications</li><li>Spreadsheet exports</li><li>Advanced text customization</li><li>Printed, animated and video invitations</li></ul></div>
                </div>
                <p class="notice">Premium purchases and RSVP collection are not enabled in this first release. Publishing below creates a free website only—no charge and no payment information required.</p>
                <div class="upgrade-actions"><button class="btn btn-outline" type="button" id="back-edit">← Edit details</button><button type="submit" class="btn">Publish my free invitation →</button></div>
            </div>
            <aside class="panel preview-panel">
                <div class="preview-head"><div><h2>Live preview</h2><div class="tiny muted">Changes appear instantly</div></div>
                    <div class="preview-tabs" role="tablist" aria-label="Invitation formats">
                        <button class="preview-tab" type="button" role="tab" aria-selected="true" data-preview-tab="website">Website</button>
                        <button class="preview-tab" type="button" role="tab" aria-selected="false" data-preview-tab="paper">Paper ◇</button>
                        <button class="preview-tab" type="button" role="tab" aria-selected="false" data-preview-tab="animated">Animated / Video ◇</button>
                    </div>
                </div>
                <div id="website-preview" class="preview-scroll">
                    <div class="preview-frame">@include('weddings.partials.invitation', ['answers' => $draft['answers'] ?? [], 'sections' => $draft['sections'] ?? [], 'questions' => $questions, 'isPreview' => true])</div>
                </div>
                <div id="paper-preview" class="preview-premium" hidden><div class="premium-placeholder"><span class="glyph">✉</span><h3>Printed invitation</h3><p>A print-ready version of this design is planned as a premium extra. Preview and export aren't active yet.</p><span class="pill">Coming soon</span></div></div>
                <div id="animated-preview" class="preview-premium" hidden><div class="premium-placeholder"><span class="glyph">✦</span><h3>Animated & video invitations</h3><p>Photo animations and video invitation versions are planned as premium extras. Rendering and downloads are not yet available.</p><span class="pill">Coming soon</span></div></div>
                <div id="plan-comparison" class="preview-comparison" hidden>
                    <div class="comparison-mini"><div class="mini-name" id="free-preview-names">Amelia & Gabriel</div><div class="mini-caption">FREE — Your wedding invitation website with the essential details</div></div>
                    <div class="comparison-mini paid"><div class="mini-name" id="paid-preview-names">Amelia & Gabriel ✧</div><div class="mini-caption">PREMIUM CONCEPT — RSVP tools, additional formats and more customization (coming soon)</div></div>
                </div>
                <div class="preview-status"><span style="color:#668f69">●</span> <span id="preview-status-text">Live preview · Saved when you publish</span></div>
            </aside>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
(function(){
    'use strict';
    const form = document.getElementById('wedding-form');
    const preview = document.getElementById('wedding-invite');
    const fields = [...form.querySelectorAll('[data-question]')];
    const groups = [...form.querySelectorAll('[data-group]')];
    const toggles = [...form.querySelectorAll('[data-section-toggle]')];

    function dateFormat(raw) {
        if (!raw) return '';
        const parts = raw.split('-');
        if (parts.length !== 3) return raw;
        const date = new Date(Number(parts[0]), Number(parts[1]) - 1, Number(parts[2]));
        return Number.isNaN(date.getTime()) ? raw : date.toLocaleDateString('en-US', {month:'long', day:'numeric', year:'numeric'});
    }
    function timeFormat(raw) {
        if (!raw || !/^[0-9]{2}:[0-9]{2}$/.test(raw)) return raw;
        const [h,m] = raw.split(':').map(Number);
        return ((h + 11) % 12 + 1) + ':' + String(m).padStart(2,'0') + (h >= 12 ? ' PM' : ' AM');
    }
    function refresh() {
        const values = {};
        fields.forEach(input => { values[input.dataset.question] = input.value; });
        preview.querySelectorAll('[data-field]').forEach(target => {
            const key = target.dataset.field;
            const input = fields.find(field => field.dataset.question === key);
            let value = values[key] || '';
            if (input && input.type === 'date') value = dateFormat(value);
            if (input && input.type === 'time') value = timeFormat(value);
            target.textContent = value || target.dataset.fallback || '';
            const extraRow = target.closest('[data-extra-row]');
            if (extraRow) extraRow.hidden = !value.trim();
        });
        groups.forEach(group => {
            const toggle = group.querySelector('[data-section-toggle]');
            const isVisible = !toggle || toggle.checked;
            group.classList.toggle('group-disabled', !isVisible);
            group.querySelectorAll('[data-question]').forEach(input => {
                input.disabled = !isVisible;
                if (input.dataset.requiredInitial === '1') input.required = isVisible;
            });
            const section = preview.querySelector('[data-preview-section="' + group.dataset.group + '"]');
            if (section) section.hidden = !isVisible;
        });
        const name = (values.bride_name || 'Amelia') + ' & ' + (values.groom_name || 'Gabriel');
        document.getElementById('free-preview-names').textContent = name;
        document.getElementById('paid-preview-names').textContent = name + ' ✧';
    }

    fields.forEach(input => {
        input.dataset.requiredInitial = input.required ? '1' : '0';
        input.addEventListener('input', refresh);
        input.addEventListener('change', refresh);
    });
    toggles.forEach(input => input.addEventListener('change', refresh));

    document.querySelectorAll('[data-preview-tab]').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('[data-preview-tab]').forEach(item => item.setAttribute('aria-selected', String(item === tab)));
            ['website', 'paper', 'animated'].forEach(key => document.getElementById(key + '-preview').hidden = key !== tab.dataset.previewTab);
        });
    });

    const editStage = document.getElementById('edit-stage');
    const upgradeStage = document.getElementById('upgrade-stage');
    function stage(upgrade) {
        editStage.classList.toggle('hidden', upgrade);
        upgradeStage.classList.toggle('active', upgrade);
        document.getElementById('plan-comparison').hidden = !upgrade;
        document.getElementById('preview-status-text').textContent = upgrade ? 'Free vs premium · premium preview is conceptual' : 'Live preview · Saved when you publish';
        if (upgrade) {
            const websiteTab = document.querySelector('[data-preview-tab="website"]');
            websiteTab.click();
        }
        window.scrollTo({top:0, behavior:'smooth'});
    }
    document.getElementById('choose-plan').addEventListener('click', () => {
        refresh();
        if (form.reportValidity()) stage(true);
    });
    document.getElementById('back-edit').addEventListener('click', () => stage(false));
    form.addEventListener('submit', () => {
        // Form submission must only include currently visible questions.
        refresh();
    });
    refresh();
})();
</script>
@endpush
