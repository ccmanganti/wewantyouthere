<script>
(function () {
    'use strict';

    const app = document.getElementById('wedding-builder');
    if (!app) return;

    const form = document.getElementById('wedding-form');
    const draftKey = 'wwyt:wedding:draft:v2:' + app.dataset.template;
    const stageNames = app.dataset.photosEnabled === '1'
        ? ['sections', 'details', 'refine', 'photos', 'publish']
        : ['sections', 'details', 'publish'];
    const stageNodes = Array.from(app.querySelectorAll('[data-stage]'));
    const stepButtons = Array.from(app.querySelectorAll('[data-step-navigation]'));
    const questionGroups = Array.from(app.querySelectorAll('[data-question-group]'));
    const allQuestions = Array.from(app.querySelectorAll('[data-question]'));
    const sectionControls = Array.from(app.querySelectorAll('[data-section-toggle]'));
    const preview = document.getElementById('wedding-invite');
    const draftIndicator = document.getElementById('draft-indicator');
    const slugInput = document.getElementById('invitation-slug');
    const slugFeedback = document.getElementById('slug-availability');
    const invitationBase = slugInput.dataset.invitationBase;
    const slugPattern = /^[a-z0-9]+(?:-[a-z0-9]+)*$/;
    let slugWasEdited = Boolean(slugInput.value);
    let slugCheckTimer = null;
    let slugCheckId = 0;
    let slugAvailability = 'unknown';
    const groups = questionGroups.map(function (node) { return node.dataset.questionGroup; });
    const stageIcons = {
        sections: 'Choose sections',
        details: 'Add your details',
        refine: 'Fine-tune template',
        photos: 'Add your photos',
        publish: 'Review & publish'
    };
    let stage = 'sections';
    let reachedStage = 0;
    let currentGroup = groups[0] || 'couple';
    let draftSupported = true;
    let advancedOpen = {};
    let restoring = true;
    let suppressNextGroupPreviewScroll = false;

    function controlFor(key) {
        return sectionControls.find(function (element) { return element.dataset.sectionToggle === key; });
    }

    function selected(key) {
        const control = controlFor(key);
        return !control || control.checked;
    }

    function activeGroups() {
        return groups.filter(selected);
    }

    function questionGroup(key) {
        return questionGroups.find(function (node) { return node.dataset.questionGroup === key; });
    }

    function fieldFor(key) {
        return allQuestions.find(function (node) { return node.dataset.question === key; });
    }

    function dateFormat(raw) {
        if (!raw || !/^\d{4}-\d{2}-\d{2}$/.test(raw)) return raw;
        const parts = raw.split('-').map(Number);
        const d = new Date(parts[0], parts[1] - 1, parts[2]);
        return Number.isNaN(d.getTime()) ? raw : d.toLocaleDateString('en-US', {
            month: 'long', day: 'numeric', year: 'numeric'
        });
    }

    function timeFormat(raw) {
        if (!raw || !/^\d{2}:\d{2}$/.test(raw)) return raw;
        const parts = raw.split(':').map(Number);
        return ((parts[0] + 11) % 12 + 1) + ':' + String(parts[1]).padStart(2, '0') +
            (parts[0] >= 12 ? ' PM' : ' AM');
    }

    function currentAnswers() {
        const answers = {};
        allQuestions.forEach(function (element) {
            answers[element.dataset.question] = element.value;
        });
        return answers;
    }

    function currentSelections() {
        const sections = {};
        groups.forEach(function (key) {
            sections[key] = selected(key);
        });
        sections.maps = selected('maps');
        sections.ceremony_details = selected('ceremony_details');
        return sections;
    }

    function writeDraft() {
        if (restoring) return;
        const payload = {
            version: 2,
            template: app.dataset.template,
            answers: currentAnswers(),
            sections: currentSelections(),
            stage: stage,
            reachedStage: reachedStage,
            group: currentGroup,
            advancedOpen: advancedOpen,
            includeParents: !!document.getElementById('include-parents')?.checked,
            fineTuneOpen: Array.from(app.querySelectorAll('[data-fine-tune-group][open]')).map(node => node.dataset.fineTuneGroup),
            slug: slugInput.value,
            slugManual: slugWasEdited,
            savedAt: new Date().toISOString()
        };
        try {
            localStorage.setItem(draftKey, JSON.stringify(payload));
            draftSupported = true;
            draftIndicator.dataset.state = 'saved';
            draftIndicator.textContent = 'Saved on this browser';
        } catch (error) {
            draftSupported = false;
            draftIndicator.dataset.state = 'unavailable';
            draftIndicator.textContent = 'Draft saving unavailable';
            document.getElementById('preview-caption').textContent =
                'This browser cannot save your draft. Keep this tab open until publishing.';
        }
    }

    function readDraft() {
        try {
            const saved = localStorage.getItem(draftKey);
            if (!saved) return null;
            const parsed = JSON.parse(saved);
            if (!parsed || parsed.version !== 2 || parsed.template !== app.dataset.template ||
                !parsed.answers || !parsed.sections || Array.isArray(parsed.answers)) return null;
            return parsed;
        } catch (error) {
            return null;
        }
    }

    function restoreDraft(saved) {
        if (!saved) return;
        allQuestions.forEach(function (element) {
            const value = saved.answers[element.dataset.question];
            if (typeof value === 'string' || typeof value === 'number') {
                element.value = String(value);
            }
        });
        sectionControls.forEach(function (element) {
            if (typeof saved.sections[element.dataset.sectionToggle] === 'boolean') {
                element.checked = saved.sections[element.dataset.sectionToggle];
            }
        });
        const includeParents = document.getElementById('include-parents');
        if (includeParents && typeof saved.includeParents === 'boolean') includeParents.checked = saved.includeParents;
        if (Array.isArray(saved.fineTuneOpen)) {
            app.querySelectorAll('[data-fine-tune-group]').forEach(function (container) {
                container.open = saved.fineTuneOpen.includes(container.dataset.fineTuneGroup);
            });
        }
        if (typeof saved.slug === 'string') slugInput.value = saved.slug.slice(0, 72);
        if (typeof saved.slugManual === 'boolean') slugWasEdited = saved.slugManual;
        advancedOpen = saved.advancedOpen && typeof saved.advancedOpen === 'object'
            ? saved.advancedOpen : {};
        if (groups.includes(saved.group)) currentGroup = saved.group;
        reachedStage = Number.isInteger(saved.reachedStage)
            ? Math.max(0, Math.min(stageNames.length - 1, saved.reachedStage)) : 0;
        if (stageNames.includes(saved.stage)) stage = saved.stage;
        reachedStage = Math.max(reachedStage, stageNames.indexOf(stage));
    }

    function revealAdvanced(groupKey, expanded) {
        const container = questionGroup(groupKey);
        if (!container) return;
        const button = app.querySelector('[data-expand-questions="' + groupKey + '"]');
        container.classList.toggle('show-advanced', expanded);
        advancedOpen[groupKey] = expanded;
        if (button) {
            button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
            const total = container.querySelectorAll('[data-advanced-fields] [data-question]').length;
            button.textContent = expanded ? '− Hide optional details' : '＋ More optional details (' + total + ')';
        }
    }

    function suggestSlug() {
        const first = fieldFor('bride_name')?.value || '';
        const second = fieldFor('groom_name')?.value || '';
        const pair = [first, second].filter(Boolean).join(' and ');
        const normalized = (pair || 'our-wedding').normalize('NFKD').replace(/[\u0300-\u036f]/g, '')
            .toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '')
            .slice(0, 72).replace(/-+$/g, '');

        return normalized || 'our-wedding';
    }

    function showSlugStatus(state, message) {
        slugAvailability = state;
        slugFeedback.dataset.state = state;
        slugFeedback.textContent = message;
    }

    function updateFullUrl() {
        const url = invitationBase + (slugInput.value || 'your-wedding');
        document.getElementById('full-invitation-url').textContent = url;
    }

    async function checkSlugAvailable() {
        const currentSlug = slugInput.value;
        const id = ++slugCheckId;
        updateFullUrl();

        slugInput.setCustomValidity('');
        if (currentSlug.length < 3 || currentSlug.length > 72 || !slugPattern.test(currentSlug)) {
            showSlugStatus('invalid', 'Use 3–72 lowercase letters, numbers or single hyphens. No spaces.');
            return false;
        }

        showSlugStatus('checking', 'Checking availability...');
        try {
            const endpoint = slugInput.dataset.availabilityUrl + '?slug=' + encodeURIComponent(currentSlug);
            const response = await fetch(endpoint, {credentials: 'same-origin', headers: {'Accept': 'application/json'}});
            if (!response.ok) throw new Error('Could not check this address');
            const result = await response.json();
            if (id !== slugCheckId || slugInput.value !== currentSlug) return false;
            if (result.available === true) {
                showSlugStatus('available', '✓ This invitation link is available.');
                return true;
            }
            slugInput.setCustomValidity('This invitation link is already taken. Please choose another.');
            showSlugStatus('unavailable', 'This link is already taken. Try another variation.');
            return false;
        } catch (error) {
            if (id === slugCheckId) showSlugStatus('unknown', 'Live checking is unavailable. We will confirm when you publish.');
            return false;
        }
    }

    function queueSlugCheck() {
        if (slugCheckTimer !== null) clearTimeout(slugCheckTimer);
        slugInput.setCustomValidity('');
        slugCheckId++;
        updateFullUrl();
        if (!slugPattern.test(slugInput.value) || slugInput.value.length < 3) {
            showSlugStatus('invalid', 'Use at least 3 lowercase letters, numbers or hyphens.');
            return;
        }
        showSlugStatus('checking', 'Checking availability...');
        slugCheckTimer = setTimeout(checkSlugAvailable, 400);
    }

    function updateSuggestedSlug() {
        if (slugWasEdited) return;
        slugInput.value = suggestSlug();
        queueSlugCheck();
    }

    function refreshSections() {
        const enabled = activeGroups();
        app.querySelectorAll('[data-section-input]').forEach(function (input) {
            input.value = selected(input.dataset.sectionInput) ? '1' : '0';
        });
        app.querySelectorAll('[data-question-group], [data-fine-tune-group]').forEach(function (group) {
            const key = group.dataset.questionGroup || group.dataset.fineTuneGroup;
            const groupEnabled = selected(key);
            group.querySelectorAll('[data-question]').forEach(function (input) {
                const familyAllowed = !input.hasAttribute('data-family-field')
                    || !!document.getElementById('include-parents')?.checked;
                input.disabled = !groupEnabled || !familyAllowed;
                input.required = groupEnabled && familyAllowed && input.dataset.requiredInitial === '1';
            });
            if (group.matches('[data-fine-tune-group]')) group.hidden = !groupEnabled;
        });
        app.querySelectorAll('[data-group-tab]').forEach(function (tab) {
            tab.hidden = !selected(tab.dataset.groupTab);
        });
        preview.querySelectorAll('[data-preview-section]').forEach(function (section) {
            section.hidden = !selected(section.dataset.previewSection);
        });
        preview.querySelectorAll('[data-nav-section]').forEach(function (link) {
            link.hidden = !selected(link.dataset.navSection);
        });
        preview.querySelectorAll('[data-premium-section]').forEach(function (node) {
            node.hidden = !selected(node.dataset.premiumSection)
                || (node.dataset.previewSection === 'reception' && !selected('reception'));
        });
        const counter = document.getElementById('section-selection-count');
        counter.textContent = enabled.length + ' sections selected · Change them anytime';
        if (!enabled.includes(currentGroup)) currentGroup = enabled[0] || groups[0];
        refreshParentVisibility();
    }

    function refreshParentVisibility() {
        const enabled = !!document.getElementById('include-parents')?.checked;
        const parentFields = Array.from(app.querySelectorAll('[data-family-field]'));
        const parentContainer = document.getElementById('family-fields');
        if (parentContainer) parentContainer.hidden = !enabled;
        parentFields.forEach(function (field) { field.disabled = !enabled; });
        const anyFilled = enabled && parentFields.some(function (field) { return field.value.trim() !== ''; });
        preview.querySelectorAll('[data-parent-card]').forEach(function (card) {
            const key = card.dataset.parentCard;
            const field = fieldFor(key);
            card.hidden = !enabled || !field || !String(field.value || '').trim();
        });
        const familySection = preview.querySelector('[data-parent-section]');
        if (familySection) familySection.hidden = !anyFilled;
    }

    // A newly added template can supply editable copy via data-field without
    // duplicating every string in data-fallback. Capture its original copy
    // once, before the first edit, so an empty input never blanks the preview.
    preview.querySelectorAll('[data-field]').forEach(function (target) {
        if (!target.hasAttribute('data-fallback')) {
            target.dataset.fallback = target.textContent.trim();
        }
    });

    function safeVideoEmbed(value) {
        try {
            const url = new URL(String(value || '').trim());
            if (url.protocol !== 'https:') return null;
            const host = url.hostname.toLowerCase().replace(/^www\./, '');
            const path = url.pathname.replace(/^\/+|\/+$/g, '');
            if (['youtu.be','youtube.com','m.youtube.com','youtube-nocookie.com'].includes(host)) {
                const id = host === 'youtu.be' ? path.split('/')[0]
                    : (url.searchParams.get('v') || (path.match(/^(?:embed|shorts)\/([a-zA-Z0-9_-]{11})$/) || [])[1]);
                return /^[a-zA-Z0-9_-]{11}$/.test(id || '') ? 'https://www.youtube-nocookie.com/embed/' + id : null;
            }
            if (host === 'vimeo.com' || host === 'player.vimeo.com') {
                const match = path.match(/^(?:video\/)?(\d{6,12})$/);
                return match ? 'https://player.vimeo.com/video/' + match[1] : null;
            }
        } catch (_) { /* Invalid URL: keep the preview placeholder. */ }
        return null;
    }

    function refreshVideoPreview(values) {
        const section = preview.querySelector('#wedding-video');
        if (!section) return;
        const container = section.querySelector('.wwyt-premium-video-inner');
        if (!container) return;
        const url = safeVideoEmbed(values.video_embed_url);
        let frame = container.querySelector('.wwyt-video-frame');
        let placeholder = container.querySelector('.wwyt-video-empty');
        if (!url) {
            if (frame) frame.remove();
            if (!placeholder) {
                placeholder = document.createElement('div');
                placeholder.className = 'wwyt-video-empty';
                placeholder.textContent = 'Add a YouTube or Vimeo link to preview your video.';
                container.appendChild(placeholder);
            }
            return;
        }
        if (placeholder) placeholder.remove();
        if (!frame) {
            frame = document.createElement('div');
            frame.className = 'wwyt-video-frame';
            const iframe = document.createElement('iframe');
            iframe.title = 'Your wedding video preview';
            iframe.loading = 'lazy';
            iframe.allowFullscreen = true;
            iframe.setAttribute('allow', 'encrypted-media; picture-in-picture');
            frame.appendChild(iframe);
            container.appendChild(frame);
        }
        const iframe = frame.querySelector('iframe');
        if (iframe && iframe.getAttribute('src') !== url) iframe.setAttribute('src', url);
    }

    function refreshPreview() {
        const values = currentAnswers();
        preview.querySelectorAll('[data-field]').forEach(function (target) {
            const key = target.dataset.field;
            const input = fieldFor(key);
            let value = values[key] || '';
            // One venue entry in the basics form populates both the venue
            // showcase and ceremony location unless separately overridden.
            if (key === 'ceremony_venue' && !value) value = values.venue_name || '';
            if (input && input.type === 'date') value = dateFormat(value);
            if (input && input.type === 'time') value = timeFormat(value);
            target.textContent = value || target.dataset.fallback || '';
            const extra = target.closest('[data-extra-row]');
            if (extra) extra.hidden = !String(values[key] || '').trim();
        });
        refreshVideoPreview(values);
        const bride = values.bride_name || 'Amelia';
        const groom = values.groom_name || 'Gabriel';
        refreshParentVisibility();
        preview.querySelectorAll('[data-optional-field-row]').forEach(function (row) {
            const key = row.dataset.optionalFieldRow;
            row.hidden = !String(values[key] || '').trim();
        });
        preview.querySelectorAll('[data-program-time]').forEach(function (row) {
            const hasTime = String(values[row.dataset.programTime] || '').trim();
            const hasNote = String(values[row.dataset.programNote] || '').trim();
            row.hidden = !hasTime && !hasNote;
        });
        // An entourage is optional even if initially selected: don't publish
        // an empty family or wedding-party showcase.
        const hasEntourage = [
            'principal_sponsors','maid_of_honor','matron_of_honor','best_man',
            'bridesmaids','groomsmen','secondary_sponsors','flower_girls',
            'ring_bearer','coin_bearer','bible_bearer','candle_sponsors',
            'veil_sponsors','cord_sponsors','officiant_name'
        ].some(function (key) { return String(values[key] || '').trim(); });
        preview.querySelectorAll('#our-people, #people-art').forEach(function (section) {
            section.hidden = !selected('entourage') || !hasEntourage;
        });
        window.dispatchEvent(new Event('wwyt:preview-updated'));
    }

    // Linked-preview spotlight. All navigation stays inside the preview pane,
    // never scrolls the editor out of view, and does not interrupt typing.
    const spotlightPane = document.getElementById('preview-scroll');
    const spotlightStatus = document.getElementById('preview-highlight-status');
    const spotlightReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const spotlightIds = {
        couple: 'cover', ceremony: 'the-date', reception: 'venue-photo-story',
        entourage: 'our-people', program: 'the-timeline', video: 'wedding-video',
        guests: 'rsvp', details: 'dress-information'
    };
    let spotlightTarget = null;
    let spotlightPendingScroll = null;
    let removedPreviewTimer = null;
    let removedPreviewNode = null;
    let removedPreviewGroup = null;

    function clearRemovedPreview() {
        if (removedPreviewTimer !== null) clearTimeout(removedPreviewTimer);
        removedPreviewTimer = null;
        if (removedPreviewNode) {
            removedPreviewNode.classList.remove('wwyt-preview-removed');
            if (!selected(removedPreviewGroup)) removedPreviewNode.hidden = true;
        }
        removedPreviewNode = null;
        removedPreviewGroup = null;
    }

    function groupPreviewTarget(groupKey) {
        const preferred = preview.querySelector('#' + (spotlightIds[groupKey] || ('wedding-' + groupKey)));
        if (preferred) return preferred;
        const matches = Array.from(preview.querySelectorAll('[data-preview-section]'))
            .filter(function (node) { return node.dataset.previewSection === groupKey; });
        return matches.find(function (node) { return !node.closest('[hidden]'); }) || matches[0] || null;
    }

    function scrollSpotlightIntoView(target) {
        if (!target || !spotlightPane) return;
        if (window.innerWidth <= 850 && app.dataset.mobileView !== 'preview') {
            // Keep the form visible on phones; honor the highlight once Preview is tapped.
            spotlightPendingScroll = target;
            return;
        }
        const box = spotlightPane.getBoundingClientRect();
        const selectedBox = target.getBoundingClientRect();
        const offset = Math.max(14, Math.min(90, spotlightPane.clientHeight * .18));
        spotlightPane.scrollTo({
            top: Math.max(0, spotlightPane.scrollTop + selectedBox.top - box.top - offset),
            behavior: spotlightReducedMotion.matches ? 'auto' : 'smooth'
        });
        spotlightPendingScroll = null;
    }

    function spotlightElement(target, message, moveToTarget) {
        if (!target) return;
        const parentSection = target.matches('section, [data-preview-section]')
            ? target : (target.closest('section, [data-preview-section]') || target);
        const previousSection = preview.querySelector('.wwyt-preview-section-active');
        const previousField = preview.querySelector('.wwyt-preview-field-active');
        if (previousSection !== parentSection) {
            previousSection?.classList.remove('wwyt-preview-section-active');
            parentSection.classList.add('wwyt-preview-section-active');
        }
        if (previousField && previousField !== target) {
            previousField.classList.remove('wwyt-preview-field-active');
        }
        if (target !== parentSection) target.classList.add('wwyt-preview-field-active');
        spotlightTarget = target;
        if (spotlightStatus && message) spotlightStatus.textContent = message;
        if (moveToTarget) scrollSpotlightIntoView(target);
    }

    function spotlightSection(groupKey) {
        clearRemovedPreview();
        const target = groupPreviewTarget(groupKey);
        if (!target) return;
        const tab = app.querySelector('[data-group-tab="' + groupKey + '"]');
        const label = tab?.textContent.trim() || groupKey;
        if (!selected(groupKey)) {
            // A removed section is briefly revealed in a muted state so the
            // user sees exactly what their selection has removed.
            target.hidden = false;
            target.classList.add('wwyt-preview-removed');
            removedPreviewNode = target;
            removedPreviewGroup = groupKey;
            spotlightElement(target, label + ' removed from your invitation', true);
            removedPreviewTimer = window.setTimeout(function () {
                target.classList.remove('wwyt-preview-removed', 'wwyt-preview-section-active');
                if (!selected(groupKey)) target.hidden = true;
                if (removedPreviewNode === target) {
                    removedPreviewNode = null;
                    removedPreviewGroup = null;
                }
                removedPreviewTimer = null;
            }, spotlightReducedMotion.matches ? 800 : 1750);
        } else {
            spotlightElement(target, label + ' highlighted in your live invitation', true);
        }
    }

    function spotlightQuestion(field, shouldScroll) {
        if (!field || field.disabled) return;
        clearRemovedPreview();
        const key = field.dataset.question;
        const groupKey = field.closest('[data-question-group]')?.dataset.questionGroup
            || field.closest('[data-fine-tune-group]')?.dataset.fineTuneGroup || 'couple';
        const candidates = Array.from(preview.querySelectorAll('[data-field]'))
            .filter(function (node) {
                return node.dataset.field === key && !node.closest('#rbv-intro') && !node.closest('[hidden]');
            });
        const preferred = candidates.find(function (node) {
            return !!node.closest('.rbv-grand,.rbv-info,[data-preview-section],.wedding-section');
        });
        const target = preferred || candidates[0] ||
            (field.closest('[data-fine-tune-subsection]')?.dataset.previewTarget
                ? preview.querySelector('#' + field.closest('[data-fine-tune-subsection]').dataset.previewTarget)
                : groupPreviewTarget(groupKey));
        if (!target || target.closest('[hidden]')) return;
        const fieldLabel = field.closest('.field')?.querySelector('label')?.textContent.trim()
            || key.replace(/_/g, ' ');
        spotlightElement(target, fieldLabel + ' in your invitation', shouldScroll);
    }

    function renderGroup() {
        const enabled = activeGroups();
        if (!enabled.length) return;
        if (!enabled.includes(currentGroup)) currentGroup = enabled[0];
        const index = enabled.indexOf(currentGroup);
        const currentNode = questionGroup(currentGroup);
        questionGroups.forEach(function (group) {
            group.classList.toggle('is-current', group === currentNode);
        });
        app.querySelectorAll('[data-group-tab]').forEach(function (tab) {
            const isCurrent = tab.dataset.groupTab === currentGroup;
            tab.classList.toggle('is-current', isCurrent);
            tab.setAttribute('aria-current', isCurrent ? 'step' : 'false');
        });
        const title = app.querySelector('[data-group-tab="' + currentGroup + '"]');
        document.getElementById('detail-stage-title').textContent = title ? title.textContent.trim() : 'Your details';
        document.getElementById('group-counter').textContent = 'Section ' + (index + 1) + ' of ' + enabled.length;
        document.getElementById('group-subtitle').textContent = currentNode.dataset.groupDescription || '';
        document.getElementById('details-next').textContent =
            index === enabled.length - 1
                ? (app.dataset.photosEnabled === '1' ? 'Fine-tune template →' : 'Review & publish →')
                : 'Next section →';
        document.getElementById('details-previous').textContent =
            index === 0 ? '← Choose sections' : '← Previous section';
        const detailScroll = document.getElementById('detail-scroll');
        detailScroll.scrollTop = 0;
        if (stage === 'details' && !suppressNextGroupPreviewScroll) spotlightSection(currentGroup);
        suppressNextGroupPreviewScroll = false;
    }

    function renderReview() {
        const list = document.getElementById('review-sections');
        list.replaceChildren();
        activeGroups().forEach(function (key) {
            const tab = app.querySelector('[data-group-tab="' + key + '"]');
            const li = document.createElement('li');
            const label = document.createElement('strong');
            label.textContent = tab ? tab.textContent.trim() : key;
            const status = document.createElement('span');
            status.textContent = 'Included ✓';
            li.append(label, status);
            list.appendChild(li);
        });

        const values = currentAnswers();
        const essentials = document.getElementById('review-essentials');
        if (essentials) {
            essentials.replaceChildren();
            const rows = [
                ['Couple', [values.bride_name, values.groom_name].filter(Boolean).join(' & ')],
                ['Wedding date', dateFormat(values.event_date)],
                ['Ceremony', values.ceremony_venue || values.venue_name],
                ['Reception', selected('reception') ? values.reception_venue : 'Not included'],
                ['Program', selected('program') ? (values.event_schedule ? 'Your wedding timeline is ready' : 'Optional timeline not added') : 'Not included'],
                ['Parents', document.getElementById('include-parents')?.checked
                    ? ['bride_mother','bride_father','groom_mother','groom_father']
                        .filter(key => String(values[key] || '').trim()).length + ' name(s) included'
                    : 'Omitted (optional)'],
                ['Entourage', selected('entourage') ? 'Included' : 'Not included'],
                ['RSVP', selected('guests') ? 'Included' : 'Not included']
            ];
            rows.forEach(function ([label, value]) {
                const row = document.createElement('div');
                row.className = 'final-review-row';
                const key = document.createElement('span');
                key.textContent = label;
                const result = document.createElement('strong');
                result.textContent = String(value || 'Not provided yet');
                row.append(key, result);
                essentials.append(row);
            });
        }

        const messages = document.getElementById('review-messages');
        if (messages) {
            messages.replaceChildren();
            const keys = [
                ['host_message', 'Invitation message'],
                ['couple_story', 'Love story'],
                ['hero_quote', 'Favorite quote'],
                ['editorial_quote', 'Editorial quote'],
                ['rsvp_message', 'RSVP wording'],
                ['gift_message', 'Gift note'],
                ['closing_quote', 'Closing quote'],
                ['closing_message', 'Final message']
            ];
            keys.forEach(function ([key, label]) {
                const field = fieldFor(key);
                if (!field || field.disabled) return;
                // Show the wording guests actually see, including the
                // template default when the optional field is blank.
                const displayed = String(
                    values[key] || preview.querySelector('[data-field="' + key + '"]')?.textContent || ''
                ).trim();
                if (!displayed) return;
                const row = document.createElement('div');
                row.className = 'review-message-entry';
                const name = document.createElement('strong');
                name.textContent = label;
                const message = document.createElement('p');
                message.textContent = displayed;
                row.append(name, message);
                messages.append(row);
            });
            if (!messages.childElementCount) {
                const empty = document.createElement('p');
                empty.className = 'review-empty';
                empty.textContent = 'No additional messages entered yet. You can still publish or add personal wording.';
                messages.append(empty);
            }
        }
    }

    function renderStage() {
        stageNodes.forEach(function (node) {
            const active = node.dataset.stage === stage;
            node.classList.toggle('is-active', active);
            node.setAttribute('aria-hidden', active ? 'false' : 'true');
        });
        const currentStageIndex = stageNames.indexOf(stage);
        stepButtons.forEach(function (button, index) {
            button.classList.toggle('is-current', index === currentStageIndex);
            button.classList.toggle('is-done', index < currentStageIndex);
            button.disabled = index > reachedStage;
            if (index === currentStageIndex) button.setAttribute('aria-current', 'step');
            else button.removeAttribute('aria-current');
        });
        if (stage === 'details') renderGroup();
        if (stage === 'publish') renderReview();

    }

    function goToStage(nextStage) {
        if (!stageNames.includes(nextStage)) return;
        const index = stageNames.indexOf(nextStage);
        if (index > reachedStage) reachedStage = index;
        stage = nextStage;
        renderStage();
        writeDraft();
    }

    function setMobileView(mode) {
        if (!['edit', 'preview'].includes(mode)) return;
        app.dataset.mobileView = mode;
        document.getElementById('mobile-edit').setAttribute('aria-pressed', mode === 'edit' ? 'true' : 'false');
        document.getElementById('mobile-preview').setAttribute('aria-pressed', mode === 'preview' ? 'true' : 'false');
        if (mode === 'preview' && spotlightPendingScroll) {
            // Wait until the pane is visible before measuring its position.
            window.requestAnimationFrame(function () {
                if (spotlightPendingScroll) scrollSpotlightIntoView(spotlightPendingScroll);
            });
        }
    }

    function validateGroup(key) {
        const group = questionGroup(key);
        if (!group) return true;
        const fineTune = app.querySelector('[data-fine-tune-group="' + key + '"]');
        const controls = Array.from(group.querySelectorAll('[data-question]'))
            .concat(Array.from(fineTune?.querySelectorAll('[data-question]') || []))
            .filter(function (input) { return !input.disabled; });
        const invalid = controls.find(function (input) { return !input.checkValidity(); });
        if (!invalid) return true;
        currentGroup = key;
        const extra = invalid.closest('[data-fine-tune-group]');
        goToStage(extra ? 'refine' : 'details');
        if (extra) extra.open = true;
        setMobileView('edit');
        invalid.focus();
        invalid.reportValidity();
        writeDraft();
        return false;
    }

    function validateAllGroups() {
        for (const key of activeGroups()) {
            if (!validateGroup(key)) return false;
        }
        return true;
    }

    function goForward() {
        const enabled = activeGroups();
        const index = enabled.indexOf(currentGroup);
        if (!validateGroup(currentGroup)) return;
        if (index < enabled.length - 1) {
            currentGroup = enabled[index + 1];
            renderGroup();
            writeDraft();
        } else if (validateAllGroups()) {
            goToStage(app.dataset.photosEnabled === '1' ? 'refine' : 'publish');
        }
    }

    // A local-only draft survives reloads, navigating away and restarting the browser.
    // No automatic expiration or clearing on form submission, because sign-up may be next.
    const restored = readDraft();
    restoreDraft(restored);
    questionGroups.forEach(function (group) {
        const groupKey = group.dataset.questionGroup;
        const filledExtras = Array.from(group.querySelectorAll('[data-advanced-fields] [data-question]'))
            .some(function (input) { return String(input.value || '').trim() !== ''; });
        revealAdvanced(groupKey, !!advancedOpen[groupKey] || filledExtras);
    });

    refreshSections();
    refreshPreview();
    updateSuggestedSlug();
    if (slugWasEdited) queueSlugCheck();
    renderStage();
    restoring = false;
    writeDraft();

    allQuestions.forEach(function (field) {
        // Only fine-tuning moves the preview to the exact field.
        // Basic details remain stationary while the couple types.
        field.addEventListener('focus', function () {
            spotlightQuestion(field, stage === 'refine' && !!field.closest('[data-fine-tune-subsection]'));
        });
        field.addEventListener('click', function () {
            if (stage === 'refine' && field.closest('[data-fine-tune-subsection]'))
                spotlightQuestion(field, true);
        });
        field.addEventListener('input', function () {
            if (field.dataset.question === 'bride_name' || field.dataset.question === 'groom_name') {
                updateSuggestedSlug();
            }
            refreshPreview();
            spotlightQuestion(field, false);
            writeDraft();
        });
        field.addEventListener('change', function () {
            refreshPreview();
            spotlightQuestion(field, false);
            writeDraft();
        });
    });

    // Offline-content / online-database wording picker: one suggestion at a
    // time, editable as normal form text, with a one-step Undo per field.
    // This deliberately does not rely on AI subscriptions or external APIs.
    const suggestionHistory = new Map();
    const previousSuggestionIds = new Map();
    app.querySelectorAll('[data-generate-field]').forEach(function (button) {
        button.addEventListener('click', async function () {
            const key = button.dataset.generateField;
            const field = fieldFor(key);
            const feedback = app.querySelector('[data-generate-feedback="' + key + '"]');
            const undo = app.querySelector('[data-undo-generated="' + key + '"]');
            if (!field || field.disabled) return;
            const search = new URLSearchParams({field:key});
            const last = previousSuggestionIds.get(key);
            if (last) search.set('exclude', String(last));
            button.disabled = true;
            button.textContent = 'Generating…';
            if (feedback) feedback.textContent = 'Choosing a message from our collection…';
            try {
                const response = await fetch(app.dataset.generateUrl + '?' + search.toString(), {
                    credentials:'same-origin', headers:{Accept:'application/json'}
                });
                const data = await response.json();
                if (!response.ok || typeof data.content !== 'string') {
                    throw new Error(data.message || 'Could not get a suggestion right now.');
                }
                suggestionHistory.set(key, field.value);
                previousSuggestionIds.set(key, data.id);
                field.value = data.content;
                field.dispatchEvent(new Event('input', {bubbles:true}));
                if (undo) undo.hidden = false;
                if (feedback) feedback.textContent = 'Suggestion added. Edit it freely, or select Generate again.';
                spotlightQuestion(field, false);
            } catch (error) {
                if (feedback) feedback.textContent = error.message || 'Unable to load a suggestion. Please try again.';
            } finally {
                button.disabled = false;
                button.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Generate';
            }
        });
    });
    app.querySelectorAll('[data-undo-generated]').forEach(function (button) {
        button.addEventListener('click', function () {
            const key = button.dataset.undoGenerated;
            const field = fieldFor(key);
            if (!field || !suggestionHistory.has(key)) return;
            field.value = suggestionHistory.get(key);
            field.dispatchEvent(new Event('input', {bubbles:true}));
            suggestionHistory.delete(key);
            button.hidden = true;
            const feedback = app.querySelector('[data-generate-feedback="' + key + '"]');
            if (feedback) feedback.textContent = 'Previous wording restored.';
        });
    });

    // Click any editable preview text to jump to its existing form control.
    // Input focus never scrolls the preview to a distant invitation section.
    function openEditorForPreviewText(target) {
        let key = target.dataset.field;
        if (key === 'ceremony_venue' && !String(fieldFor('ceremony_venue')?.value || '').trim()) {
            key = 'venue_name';
        }
        const field = fieldFor(key);
        if (!field || field.disabled) return false;
        const fineTune = field.closest('[data-fine-tune-group]');
        const group = fineTune?.dataset.fineTuneGroup ||
            field.closest('[data-question-group]')?.dataset.questionGroup;
        if (!group || !selected(group)) return false;
        currentGroup = group;
        // Clicking preview text selects its own existing field, in the correct
        // step, without moving the preview to a different chapter.
        suppressNextGroupPreviewScroll = true;
        goToStage(fineTune ? 'refine' : 'details');
        if (fineTune) fineTune.open = true;
        const subScene = field.closest('[data-fine-tune-subsection]');
        if (subScene && !subScene.open) {
            // Opening a control after clicking its preview text must not
            // scroll the preview away from the element that was clicked.
            subScene.dataset.skipPreviewJump = '1';
            subScene.open = true;
        }
        if (app.dataset.previewExpanded === 'true') document.getElementById('preview-expand')?.click();
        setMobileView('edit');
        if (field.hasAttribute('data-family-field')) {
            const toggle = document.getElementById('include-parents');
            if (toggle && !toggle.checked) {
                toggle.checked = true;
                refreshSections();
            }
        }
        const pane = fineTune ? fineTune.closest('.stage-scroll') : document.getElementById('detail-scroll');
        const paneBounds = pane.getBoundingClientRect();
        const fieldBounds = field.getBoundingClientRect();
        pane.scrollTop += fieldBounds.top - paneBounds.top - Math.max(18, pane.clientHeight * .18);
        try { field.focus({preventScroll:true}); } catch (_) { field.focus(); }
        spotlightElement(target, 'Editing ' + (field.closest('.field')?.querySelector('label')?.textContent.trim() || key), false);
        return true;
    }

    preview.querySelectorAll('[data-field]').forEach(function (node) {
        if (node.closest('#rbv-intro') || !fieldFor(node.dataset.field)) return;
        node.classList.add('wwyt-preview-editable');
        node.title = 'Click to edit this text';
        if (!node.closest('button, a, input, select, textarea')) {
            node.setAttribute('tabindex', '0');
            node.setAttribute('role', 'button');
            node.setAttribute('aria-label', 'Edit ' + (node.textContent.trim().slice(0, 70) || node.dataset.field));
            node.addEventListener('keydown', function (event) {
                if (event.key !== 'Enter' && event.key !== ' ') return;
                event.preventDefault();
                openEditorForPreviewText(node);
            });
        }
    });

    preview.addEventListener('click', function (event) {
        const textNode = event.target.closest('[data-field]');
        if (textNode && preview.contains(textNode) && !textNode.closest('#rbv-intro')
            && openEditorForPreviewText(textNode)) {
            event.preventDefault();
            event.stopPropagation();
            return;
        }
        if (app.dataset.photosEnabled !== '1') return;
        const photoNode = event.target.closest('[data-photo-slot]');
        if (!photoNode || !preview.contains(photoNode)
            || event.target.closest('a,button,input,textarea,select,label')) return;
        const card = Array.from(app.querySelectorAll('[data-photo-card]'))
            .find(function (node) { return node.dataset.photoCard === photoNode.dataset.photoSlot; });
        if (!card) return;
        event.preventDefault();
        goToStage('photos');
        if (app.dataset.previewExpanded === 'true') document.getElementById('preview-expand')?.click();
        setMobileView('edit');
        card.scrollIntoView({block:'nearest', behavior:'auto'});
        card.querySelector('[data-photo-locate]')?.click();
    }, true);

    slugInput.addEventListener('input', function () {
        // Keep links simple and copy-friendly while allowing the visitor to customize.
        const normalized = slugInput.value.toLowerCase().replace(/[^a-z0-9-]/g, '-')
            .replace(/-+/g, '-').replace(/^-+/g, '').slice(0, 72);
        if (normalized !== slugInput.value) slugInput.value = normalized;
        slugWasEdited = slugInput.value.length > 0;
        if (!slugWasEdited) slugInput.value = suggestSlug();
        queueSlugCheck();
        writeDraft();
    });

    const familyToggle = document.getElementById('include-parents');
    familyToggle?.addEventListener('change', function () {
        refreshSections();
        refreshPreview();
        writeDraft();
    });
    app.querySelectorAll('[data-fine-tune-group]').forEach(function (panel) {
        panel.addEventListener('toggle', writeDraft);
    });

    // A locked card is a clear upgrade action, not a disabled checkbox that
    // silently fails. Keep the local draft intact through login and checkout.
    const premiumDialog = document.getElementById('premium-unlock-dialog');
    app.querySelectorAll('[data-locked-feature]').forEach(function (card) {
        const open = function (event) {
            if (event) event.preventDefault();
            const feature = card.dataset.lockedFeature;
            const labels = {
                maps:'Google Maps for your church and reception',
                rsvp:'RSVP tracking with email notifications',
                video:'Your prenup or video message',
                program:'Your wedding programme',
                entourage:'Ninong, ninang and entourage',
                ceremony:'Extended ceremony details',
            };
            const description = document.getElementById('premium-modal-description');
            if (description) description.textContent =
                (labels[feature] || 'Premium invitation features')
                + ' is available with a one-time template upgrade. Your free draft stays saved.';
            writeDraft();
            premiumDialog?.showModal();
        };
        card.addEventListener('click', open);
        card.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') open(event);
        });
    });
    app.querySelectorAll('[data-premium-close]').forEach(function (button) {
        button.addEventListener('click', function () { premiumDialog?.close(); });
    });
    premiumDialog?.addEventListener('click', function (event) {
        if (event.target === premiumDialog) premiumDialog.close();
    });

    sectionControls.forEach(function (input) {
        input.addEventListener('change', function () {
            refreshSections();
            refreshPreview();
            renderGroup();
            spotlightSection(input.dataset.sectionToggle);
            writeDraft();
        });
    });
    app.querySelectorAll('[data-choice-card][data-required="true"]').forEach(function (card) {
        card.addEventListener('click', function () {
            spotlightSection(card.dataset.choiceCard);
        });
    });

    app.querySelectorAll('[data-expand-questions]').forEach(function (button) {
        button.addEventListener('click', function () {
            const key = button.dataset.expandQuestions;
            revealAdvanced(key, !questionGroup(key).classList.contains('show-advanced'));
            writeDraft();
        });
    });

    document.getElementById('sections-next').addEventListener('click', function () {
        currentGroup = activeGroups()[0] || groups[0];
        goToStage('details');
    });

    document.getElementById('details-next').addEventListener('click', goForward);
    document.getElementById('details-previous').addEventListener('click', function () {
        const enabled = activeGroups();
        const index = enabled.indexOf(currentGroup);
        if (index > 0) {
            currentGroup = enabled[index - 1];
            renderGroup();
            writeDraft();
        } else {
            goToStage('sections');
        }
    });
    document.getElementById('publish-back').addEventListener('click', function () {
        goToStage(app.dataset.photosEnabled === '1' ? 'photos' : 'details');
    });
    app.querySelectorAll('[data-review-edit]').forEach(function (button) {
        button.addEventListener('click', function () {
            const destination = button.dataset.reviewEdit;
            if (!stageNames.includes(destination)) return;
            goToStage(destination);
            setMobileView('edit');
        });
    });
    document.getElementById('review-open-preview')?.addEventListener('click', function () {
        setMobileView('preview');
        if (window.innerWidth > 850 && app.dataset.previewExpanded !== 'true') {
            document.getElementById('preview-expand')?.click();
        }
        document.getElementById('preview-scroll').scrollTop = 0;
    });
    if (app.dataset.photosEnabled === '1') {
        document.getElementById('refine-back')?.addEventListener('click', function () {
            goToStage('details');
        });
        document.getElementById('refine-next')?.addEventListener('click', function () {
            if (validateAllGroups()) goToStage('photos');
        });
        app.querySelectorAll('[data-fine-tune-subsection]').forEach(function (scene) {
            scene.addEventListener('toggle', function () {
                if (scene.dataset.skipPreviewJump === '1') {
                    delete scene.dataset.skipPreviewJump;
                    return;
                }
                if (!scene.open || stage !== 'refine') return;
                const target = preview.querySelector('#' + scene.dataset.previewTarget);
                if (target && !target.closest('[hidden]')) {
                    spotlightElement(target, 'Showing ' + scene.querySelector('summary')?.textContent.trim(), true);
                }
            });
        });
        // Each fine-tune field offers an explicit Show action, especially
        // useful on phones where the editor and preview occupy separate panes.
        app.querySelectorAll('[data-fine-tune-subsection] [data-question]').forEach(function (field) {
            const heading = field.closest('.field')?.querySelector('.field-heading');
            if (!heading) return;
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'field-preview-jump';
            button.title = 'Show this item in the invitation';
            button.innerHTML = '<i class="fa-solid fa-crosshairs" aria-hidden="true"></i> Show';
            button.addEventListener('click', function () {
                if (field.disabled) return;
                setMobileView('preview');
                spotlightQuestion(field, true);
            });
            heading.append(button);
        });
        document.getElementById('photos-back')?.addEventListener('click', function () {
            goToStage('refine');
        });
        document.getElementById('photos-next')?.addEventListener('click', function () {
            if (validateAllGroups()) goToStage('publish');
        });
    }

    app.querySelectorAll('[data-group-tab]').forEach(function (button) {
        button.addEventListener('click', function () {
            if (!selected(button.dataset.groupTab)) return;
            currentGroup = button.dataset.groupTab;
            renderGroup();
            writeDraft();
        });
    });

    stepButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const destination = button.dataset.stepNavigation;
            if (stageNames.indexOf(destination) > reachedStage) return;
            if (['refine','photos','publish'].includes(destination) && !validateAllGroups()) return;
            goToStage(destination);
            setMobileView('edit');
        });
    });

    // Optional wide-screen proofing mode. The invitation still scrolls
    // within its own pane; return to split view to continue editing.
    const previewExpand = document.getElementById('preview-expand');
    previewExpand?.addEventListener('click', function () {
        const expanded = app.dataset.previewExpanded === 'true';
        app.dataset.previewExpanded = expanded ? 'false' : 'true';
        previewExpand.setAttribute('aria-pressed', expanded ? 'false' : 'true');
        const label = previewExpand.querySelector('span');
        if (label) label.textContent = expanded ? 'Expand' : 'Split view';
        const icon = previewExpand.querySelector('i');
        if (icon) {
            icon.classList.toggle('fa-expand', expanded);
            icon.classList.toggle('fa-compress', !expanded);
        }
        previewExpand.title = expanded
            ? 'Use the full workspace to inspect the invitation'
            : 'Return to side-by-side editing';
    });

    // Keep preview navigation inside its own scrolling pane, not the builder page.
    preview.querySelectorAll('a[href^="#wedding-"]').forEach(function (link) {
        link.addEventListener('click', function (event) {
            const target = preview.querySelector(link.getAttribute('href'));
            if (!target || target.hidden) return;
            event.preventDefault();
            const pane = document.getElementById('preview-scroll');
            const destination = target.getBoundingClientRect().top -
                pane.getBoundingClientRect().top + pane.scrollTop - 15;
            pane.scrollTo({top: destination, behavior: 'smooth'});
        });
    });

    // Photo placement is activated by the photo editor once the target is
    // visible; use the same scroll calculation as fine-tune fields.
    window.addEventListener('wwyt:photo-position', function (event) {
        const slot = event.detail?.slot;
        if (!slot) return;
        const target = Array.from(preview.querySelectorAll('[data-photo-slot]')).find(function (node) {
            return node.dataset.photoSlot === slot && !node.closest('[hidden]') && !node.closest('#rbv-intro');
        });
        if (!target) return;
        setMobileView('preview');
        window.requestAnimationFrame(function () {
            spotlightElement(target, 'Photo placement highlighted', true);
        });
    });

    document.getElementById('mobile-edit').addEventListener('click', function () { setMobileView('edit'); });
    document.getElementById('mobile-preview').addEventListener('click', function () { setMobileView('preview'); });

    form.addEventListener('submit', function (event) {
        if (!validateAllGroups()) {
            event.preventDefault();
            return;
        }
        if (stage !== 'publish') {
            event.preventDefault();
            goToStage('publish');
            return;
        }
        if (!slugInput.checkValidity()) {
            event.preventDefault();
            setMobileView('edit');
            slugInput.focus();
            slugInput.reportValidity();
            return;
        }
        // Never clear here. A guest can still need to register or log in.
        writeDraft();
        const submitButton = document.getElementById('publish-free');
        submitButton.disabled = true;
        submitButton.textContent = 'Publishing...';
    });

    document.getElementById('cancel-builder-form').addEventListener('submit', function (event) {
        if (!window.confirm('Discard this invitation draft? Your answers and section selections will be lost on this browser.')) {
            event.preventDefault();
        }
        // The server confirms cancellation and then clears localStorage on the destination page.
    });

    if (!draftSupported) {
        draftIndicator.title = 'Your browser has blocked local storage. Please keep the builder open until publishing.';
    }

    window.addEventListener('pagehide', function () {
        // No clear operation: preserve the latest form state across regular navigation/reloads.
        if (draftSupported) writeDraft();
    });
})();
</script>