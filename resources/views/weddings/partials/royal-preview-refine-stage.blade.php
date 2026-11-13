<section class="editor-stage" data-stage="refine" aria-labelledby="refine-stage-title">
    <div class="stage-top">
        <span class="stage-kicker">Step 03 / 05 · Optional changes</span>
        <h2 id="refine-stage-title">Fine-tune your invitation.</h2>
        <p>Choose a section, then edit only what you need.</p>
    </div>
    <div class="stage-scroll rb-refine-scroll" id="refine-scroll">
        <div class="fine-tune-categories" id="fine-tune-categories">
            @foreach($groups as $key => $group)
                @php
                    $coreKeys = config('wedding_editor_basics.'.$key, []);
                    $legacy = ['bride_full_name', 'groom_full_name', 'bride_parents', 'groom_parents'];
                    $blocked = !$hasPremium && \App\Support\InvitationPremium::lockedGroup($key);
                    $extras = $blocked ? collect() : $group['questions']->filter(fn ($question) =>
                        !in_array($question->key, $coreKeys, true)
                        && !in_array($question->key, $legacy, true)
                        && ($hasPremium || !\App\Support\InvitationPremium::lockedField($question->key)));
                    $scenes = config('wedding_refine_sections.'.$key, []);
                    $categorizedKeys = collect($scenes)->flatMap(fn ($scene) => $scene['fields'])->all();
                    $remaining = $extras->filter(fn ($question) => !in_array($question->key, $categorizedKeys, true))->values()->chunk(6);
                @endphp
                @if($extras->isNotEmpty())
                <details class="fine-tune-category" data-fine-tune-group="{{ $key }}">
                    <summary data-fine-tune-trigger="{{ $key }}">
                        <span class="fine-tune-category-title">{{ $group['title'] }}</span>
                        <span class="fine-tune-category-count">{{ $extras->count() }} details</span>
                        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                    </summary>
                    <div class="fine-tune-scenes">
                        @foreach($scenes as $scene)
                            @php $sceneQuestions = $extras->filter(fn ($question) => in_array($question->key, $scene['fields'], true)); @endphp
                            @if($sceneQuestions->isNotEmpty())
                            <details class="fine-tune-subsection" data-fine-tune-subsection
                                data-preview-target="{{ $scene['target'] }}">
                                <summary>
                                    <span>{{ $scene['title'] }}</span>
                                    <small>{{ $sceneQuestions->count() }} fields</small>
                                    <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                                </summary>
                                <div class="question-grid fine-tune-question-grid">
                                    @foreach($sceneQuestions as $question)
                                        @include('weddings.partials.editor-question', ['question' => $question, 'draft' => $draft])
                                    @endforeach
                                </div>
                            </details>
                            @endif
                        @endforeach
                        @foreach($remaining as $index => $chunk)
                            <details class="fine-tune-subsection" data-fine-tune-subsection
                                data-preview-target="{{ ['couple'=>'our-story','ceremony'=>'location-details','reception'=>'venue-photo-story','details'=>'dress-information'][$key] ?? 'cover' }}">
                                <summary><span>Other details {{ $remaining->count() > 1 ? $index + 1 : '' }}</span>
                                    <small>{{ $chunk->count() }} fields</small><i class="fa-solid fa-chevron-down" aria-hidden="true"></i></summary>
                                <div class="question-grid fine-tune-question-grid">
                                    @foreach($chunk as $question)
                                        @include('weddings.partials.editor-question', ['question' => $question, 'draft' => $draft])
                                    @endforeach
                                </div>
                            </details>
                        @endforeach
                    </div>
                </details>
                @endif
            @endforeach
        </div>
        <details class="fine-tune-envelope">
            <summary><i class="fa-solid {{ \App\Support\CuratedWeddingDesign::isCurated($template) ? 'fa-wand-magic-sparkles' : 'fa-envelope' }}" aria-hidden="true"></i> {{ \App\Support\CuratedWeddingDesign::isCurated($template) ? 'Opening animation preview' : 'Envelope opening preview' }} <i class="fa-solid fa-chevron-down" aria-hidden="true"></i></summary>
            <div class="fine-tune-envelope-inner">
                <p>See how guests open the invitation.</p>
                <button type="button" class="rb-refine-replay" id="preview-envelope-intro">
                    <i class="fa-solid fa-play" aria-hidden="true"></i> {{ \App\Support\CuratedWeddingDesign::isCurated($template) ? 'Replay opening' : 'Play envelope' }}
                </button>
            </div>
        </details>
        @include('weddings.partials.audio-builder-stage')
    </div>
    <div class="stage-footer">
        <button type="button" class="back-btn" id="refine-back"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back</button>
        <button type="button" class="btn" id="refine-next">Next: photos <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
    </div>
</section>
