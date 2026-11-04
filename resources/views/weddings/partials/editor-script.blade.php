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
        refine: 'Preview & refine',
        photos: 'Add your photos',
        publish: 'Publish'
    };
    let stage = 'sections';
    let reachedStage = 0;
    let currentGroup = groups[0] || 'couple';
    let draftSupported = true;
    let advancedOpen = {};
    let restoring = true;

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
            button.textContent = expanded ? '− Hide extra details' : '＋ Add more details';
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
        questionGroups.forEach(function (group) {
            const groupEnabled = selected(group.dataset.questionGroup);
            group.querySelectorAll('[data-question]').forEach(function (input) {
                input.disabled = !groupEnabled;
                input.required = groupEnabled && input.dataset.requiredInitial === '1';
            });
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
        const counter = document.getElementById('section-selection-count');
        counter.textContent = enabled.length + ' sections selected · Change them anytime';
        if (!enabled.includes(currentGroup)) currentGroup = enabled[0] || groups[0];
    }

    function refreshPreview() {
        const values = currentAnswers();
        preview.querySelectorAll('[data-field]').forEach(function (target) {
            const key = target.dataset.field;
            const input = fieldFor(key);
            let value = values[key] || '';
            if (input && input.type === 'date') value = dateFormat(value);
            if (input && input.type === 'time') value = timeFormat(value);
            target.textContent = value || target.dataset.fallback || '';
            const extra = target.closest('[data-extra-row]');
            if (extra) extra.hidden = !String(values[key] || '').trim();
        });
        const bride = values.bride_name || 'Amelia';
        const groom = values.groom_name || 'Gabriel';
        app.querySelectorAll('.comparison-name').forEach(function (node) {
            node.textContent = bride + ' & ' + groom;
        });
        window.dispatchEvent(new Event('wwyt:preview-updated'));
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
                ? (app.dataset.photosEnabled === '1' ? 'Preview & refine →' : 'Review & publish →')
                : 'Next section →';
        document.getElementById('details-previous').textContent =
            index === 0 ? '← Choose sections' : '← Previous section';
        const detailScroll = document.getElementById('detail-scroll');
        detailScroll.scrollTop = 0;
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
        document.getElementById('preview-comparison').classList.toggle('is-visible', stage === 'publish');
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
    }

    function validateGroup(key) {
        const group = questionGroup(key);
        if (!group) return true;
        const activeInputs = Array.from(group.querySelectorAll('[data-question]')).filter(function (input) {
            return !input.disabled;
        });
        const invalid = activeInputs.find(function (input) { return !input.checkValidity(); });
        if (!invalid) return true;
        currentGroup = key;
        goToStage('details');
        setMobileView('edit');
        if (invalid.closest('[data-advanced-fields]')) revealAdvanced(key, true);
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
        field.addEventListener('input', function () {
            if (field.dataset.question === 'bride_name' || field.dataset.question === 'groom_name') {
                updateSuggestedSlug();
            }
            refreshPreview();
            writeDraft();
        });
        field.addEventListener('change', function () { refreshPreview(); writeDraft(); });
    });

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

    sectionControls.forEach(function (input) {
        input.addEventListener('change', function () {
            refreshSections();
            refreshPreview();
            renderGroup();
            writeDraft();
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
    if (app.dataset.photosEnabled === '1') {
        document.getElementById('refine-back')?.addEventListener('click', function () {
            goToStage('details');
        });
        document.getElementById('refine-next')?.addEventListener('click', function () {
            if (validateAllGroups()) goToStage('photos');
        });
        document.querySelectorAll('[data-refine-section]').forEach(function (button) {
            button.addEventListener('click', function () {
                const section = button.dataset.refineSection;
                const destination = preview.querySelector('#' + section);
                if (!destination || destination.hidden) return;
                const pane = document.getElementById('preview-scroll');
                const top = destination.getBoundingClientRect().top - pane.getBoundingClientRect().top + pane.scrollTop - 12;
                const websiteTab = app.querySelector('[data-preview-format="website"]');
                if (websiteTab?.getAttribute('aria-selected') !== 'true') websiteTab?.click();
                pane.scrollTo({top:Math.max(0,top),behavior:window.matchMedia('(prefers-reduced-motion:reduce)').matches?'auto':'smooth'});
                setMobileView('preview');
            });
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

    app.querySelectorAll('[data-preview-format]').forEach(function (button) {
        button.addEventListener('click', function () {
            const format = button.dataset.previewFormat;
            app.querySelectorAll('[data-preview-format]').forEach(function (tab) {
                tab.setAttribute('aria-selected', tab === button ? 'true' : 'false');
            });
            ['website', 'paper', 'animated'].forEach(function (name) {
                document.getElementById('preview-' + name).hidden = format !== name;
            });
            document.getElementById('preview-scroll').scrollTop = 0;
        });
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