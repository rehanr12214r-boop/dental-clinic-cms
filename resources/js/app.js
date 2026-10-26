import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

import './bootstrap';
import './animations';

/**
 * Class strings are kept as literals so Tailwind's content scan picks them up.
 */
const SLOT_BASE_CLASSES =
    'rounded-full border px-3 py-2.5 text-[12px] font-semibold transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#c2714d]';
const SLOT_AVAILABLE_CLASSES =
    'border-[#e2e3e4] bg-white text-[#3c3d42] hover:border-[#c2714d] hover:bg-[#f3efe5] hover:text-[#3c3d42]';
const SLOT_UNAVAILABLE_CLASSES =
    'cursor-not-allowed border-transparent bg-[#3c3d42]/5 text-[#3c3d42]/35';
const SLOT_SELECTED_CLASSES =
    'border-[#3c3d42] bg-[#3c3d42] text-[#fef9ef] shadow-sm hover:border-[#121212] hover:bg-[#121212]';

function initBookingPortal() {
    const config = document.getElementById('page-config');
    if (!config) {
        return;
    }

    const daysOff = config.dataset.daysOff
        .split(',')
        .filter((day) => day !== '')
        .map(Number);

    const elements = {
        step2: document.getElementById('step-2'),
        step3: document.getElementById('step-3'),
        dateInput: document.getElementById('appointment-date-picker'),
        timeInput: document.getElementById('appointment-time'),
        slotsMeta: document.getElementById('slots-meta'),
        slotsGrid: document.getElementById('slots-grid'),
        slotsLoading: document.getElementById('slots-loading'),
        slotsEmpty: document.getElementById('slots-empty'),
        slotsError: document.getElementById('slots-error'),
        form: document.getElementById('booking-form'),
        formError: document.getElementById('form-error'),
        submitButton: document.getElementById('booking-submit'),
        shell: document.getElementById('booking-shell'),
        confirmation: document.getElementById('booking-confirmation'),
        bookingAgain: document.getElementById('booking-again'),
    };

    const state = { treatment: null, date: null, time: null };
    const slotLabels = new Map();
    let selectedSlotButton = null;

    // ------------------------------------------------------------------
    // Step 2: date picker + slot fetching
    // ------------------------------------------------------------------
    flatpickr(elements.dateInput, {
        minDate: 'today',
        maxDate: config.dataset.maxDate,
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'l, F j, Y',
        disable: [(date) => daysOff.includes(date.getDay())],
        onChange: (selectedDates, dateStr) => {
            resetSlotSelection();
            state.date = dateStr || null;
            updateSummary();

            if (state.date && state.treatment) {
                loadSlots();
            } else {
                clearSlots();
            }
        },
    });

    // ------------------------------------------------------------------
    // Step 1: treatment selection
    // ------------------------------------------------------------------
    const treatmentDropdown = document.getElementById('treatment-dropdown');

    document.querySelectorAll('input[data-treatment-card]').forEach((input) => {
        input.addEventListener('change', () => {
            state.treatment = {
                id: input.value,
                name: input.dataset.name,
                durationMinutes: Number(input.dataset.duration),
                cost: Number(input.dataset.cost),
            };

            if (treatmentDropdown && treatmentDropdown.value !== input.value) {
                treatmentDropdown.value = input.value;
            }

            unlockStep(elements.step2);

            if (state.date) {
                loadSlots();
            }

            updateSummary();
        });
    });

    if (treatmentDropdown) {
        treatmentDropdown.addEventListener('change', () => {
            const val = treatmentDropdown.value;
            if (!val) {
                return;
            }
            const targetRadio = document.querySelector(`input[data-treatment-card][value="${val}"]`);
            if (targetRadio) {
                targetRadio.checked = true;
                targetRadio.dispatchEvent(new Event('change'));
            }
        });
    }

    // Dynamic selection via URL parameter (?service=slug or ?treatment=id/slug)
    const urlParams = new URLSearchParams(window.location.search);
    const serviceParam = urlParams.get('service') || urlParams.get('treatment');
    if (serviceParam) {
        let matchingInput = document.querySelector(`input[data-treatment-card][data-slug="${serviceParam}"]`)
            || document.querySelector(`input[data-treatment-card][value="${serviceParam}"]`);

        if (!matchingInput && treatmentDropdown) {
            const matchingOpt = treatmentDropdown.querySelector(`option[data-slug="${serviceParam}"]`)
                || treatmentDropdown.querySelector(`option[value="${serviceParam}"]`);
            if (matchingOpt && matchingOpt.value) {
                matchingInput = document.querySelector(`input[data-treatment-card][value="${matchingOpt.value}"]`);
            }
        }

        if (matchingInput) {
            matchingInput.checked = true;
            if (treatmentDropdown) {
                treatmentDropdown.value = matchingInput.value;
            }
            matchingInput.dispatchEvent(new Event('change'));
        }
    } else {
        const checked = document.querySelector('input[data-treatment-card]:checked');
        if (checked) {
            if (treatmentDropdown) {
                treatmentDropdown.value = checked.value;
            }
            checked.dispatchEvent(new Event('change'));
        }
    }

    // ------------------------------------------------------------------
    // Step 3: submit the booking
    // ------------------------------------------------------------------
    elements.form.addEventListener('submit', handleBookingSubmit);

    elements.bookingAgain?.addEventListener('click', () => window.location.reload());

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------
    function unlockStep(step) {
        if (!step) {
            return;
        }

        step.setAttribute('aria-disabled', 'false');
        step.classList.remove('opacity-50', 'pointer-events-none');

        const badge = step.querySelector('[data-step-badge]');
        badge?.classList.remove('bg-line', 'text-ink/40');
        badge?.classList.add('bg-ink', 'text-cream');

        step.querySelector('[data-lock-hint]')?.classList.add('hidden');
    }

    function lockStep(step) {
        if (!step) {
            return;
        }

        step.setAttribute('aria-disabled', 'true');
        step.classList.add('pointer-events-none', 'opacity-50');

        const badge = step.querySelector('[data-step-badge]');
        badge?.classList.remove('bg-ink', 'text-cream');
        badge?.classList.add('bg-line', 'text-ink/40');

        step.querySelector('[data-lock-hint]')?.classList.remove('hidden');
    }

    function toggleHidden(element, shouldHide) {
        if (element) {
            element.hidden = shouldHide;
        }
    }

    function resetSlotSelection() {
        state.time = null;
        elements.timeInput.value = '';
        selectedSlotButton = null;
        lockStep(elements.step3);
        updateSummary();
    }

    function clearSlots() {
        elements.slotsGrid.innerHTML = '';
        toggleHidden(elements.slotsGrid, true);
        toggleHidden(elements.slotsMeta, true);
        toggleHidden(elements.slotsEmpty, true);
        toggleHidden(elements.slotsError, true);
        toggleHidden(elements.slotsLoading, true);
    }

    async function loadSlots() {
        if (!state.treatment || !state.date) {
            return;
        }

        const params = new URLSearchParams({
            treatment_id: state.treatment.id,
            date: state.date,
        });

        clearSlots();
        toggleHidden(elements.slotsLoading, false);

        try {
            const response = await fetch(`${config.dataset.slotsEndpoint}?${params}`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) {
                const data = await response.json().catch(() => ({}));
                throw new Error(data.message ?? 'Could not load available time slots.');
            }

            renderSlots(await response.json());
        } catch (error) {
            elements.slotsError.textContent = error.message;
            toggleHidden(elements.slotsError, false);
        } finally {
            toggleHidden(elements.slotsLoading, true);
        }
    }

    function renderSlots(data) {
        slotLabels.clear();

        if (data.day_off || data.slots.length === 0) {
            elements.slotsEmpty.textContent = data.day_off
                ? 'The clinic is closed on this date. Please pick another day.'
                : `There are no bookable slots on ${data.date_label}. Please pick another day.`;
            toggleHidden(elements.slotsEmpty, false);
            return;
        }

        data.slots.forEach((slot) => {
            slotLabels.set(slot.time, slot.label);

            const button = document.createElement('button');
            button.type = 'button';
            button.dataset.slot = slot.time;
            button.textContent = slot.label;

            if (slot.available) {
                button.className = `${SLOT_BASE_CLASSES} ${SLOT_AVAILABLE_CLASSES}`;
                button.addEventListener('click', () => selectSlot(button, slot.available));
            } else {
                button.className = `${SLOT_BASE_CLASSES} ${SLOT_UNAVAILABLE_CLASSES}`;
                button.disabled = true;
            }

            elements.slotsGrid.appendChild(button);
        });

        const availableCount = data.available_count;
        elements.slotsMeta.textContent = availableCount > 0
            ? `${availableCount} of ${data.slots.length} time slots available on ${data.date_label}.`
            : `All slots for ${data.date_label} are already booked. Please pick another day.`;

        toggleHidden(elements.slotsMeta, false);
        toggleHidden(elements.slotsGrid, false);
    }

    function selectSlot(button) {
        if (selectedSlotButton) {
            selectedSlotButton.className = selectedSlotButton.dataset.restingClasses;
        }

        selectedSlotButton = button;
        button.dataset.restingClasses = button.className;
        button.className = `${SLOT_BASE_CLASSES} ${SLOT_SELECTED_CLASSES}`;

        state.time = button.dataset.slot;
        elements.timeInput.value = state.time;
        unlockStep(elements.step3);
        updateSummary();
    }

    async function handleBookingSubmit(event) {
        event.preventDefault();
        toggleHidden(elements.formError, true);

        if (!state.treatment || !state.date || !state.time) {
            elements.formError.textContent =
                'Please complete step 1 (treatment) and step 2 (date & time) before confirming.';
            toggleHidden(elements.formError, false);
            return;
        }

        const formData = Object.fromEntries(new FormData(elements.form).entries());
        const originalLabel = elements.submitButton.textContent;

        elements.submitButton.disabled = true;
        elements.submitButton.textContent = 'Booking…';

        try {
            const response = await fetch(config.dataset.appointmentsEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') ?? '',
                },
                body: JSON.stringify({
                    treatment_id: Number(state.treatment.id),
                    appointment_date: state.date,
                    appointment_time: state.time,
                    patient_name: (formData.patient_name ?? '').trim(),
                    patient_phone: (formData.patient_phone ?? '').trim(),
                    patient_age: Number(formData.patient_age ?? 0),
                    notes: (formData.notes ?? '').trim() || null,
                }),
            });

            const data = await response.json().catch(() => ({}));

            if (response.ok && data.appointment) {
                showToast('Appointment booked — your time slot is reserved.', 'success');
                renderConfirmation(data);
                return;
            }

            if (response.status === 401) {
                const message = 'Please log in to book an appointment.';
                elements.formError.textContent = message;
                toggleHidden(elements.formError, false);
                showToast(message, 'error');
                const returnUrl = encodeURIComponent(window.location.pathname + window.location.search);
                window.location.href = `/patient/login?intended=${returnUrl}`;
                return;
            }

            if (response.status === 409) {
                const message =
                    data.message ?? 'This slot was just booked by someone else. Please choose another one.';
                elements.formError.textContent = message;
                toggleHidden(elements.formError, false);
                showToast(message, 'error');
                loadSlots();
                return;
            }

            if (data.errors) {
                elements.formError.textContent = Object.values(data.errors).flat().join(' ');
                toggleHidden(elements.formError, false);
                showToast('Please check the highlighted fields and try again.', 'error');
                return;
            }

            throw new Error(data.message ?? 'Something went wrong while booking. Please try again.');
        } catch (error) {
            elements.formError.textContent = error.message;
            toggleHidden(elements.formError, false);
            showToast(error.message, 'error');
        } finally {
            elements.submitButton.disabled = false;
            elements.submitButton.textContent = originalLabel;
        }
    }

    function renderConfirmation(data) {
        const appointment = data.appointment ?? {};

        setText('confirmation-message', data.message);
        setText('confirmation-reference', appointment.reference);
        setText('confirmation-treatment', appointment.treatment?.name);
        setText('confirmation-date', appointment.appointment_date_label);
        setText('confirmation-time', appointment.appointment_time_label);
        setText('confirmation-name', appointment.patient_name);
        setText('confirmation-phone', appointment.patient_phone);
        setText(
            'confirmation-age',
            appointment.patient_age != null ? `${appointment.patient_age} years old` : ''
        );
        setText('confirmation-fee', appointment.treatment?.cost_label);
        setText('confirmation-status', appointment.status_label);

        elements.shell.classList.add('hidden');
        elements.confirmation.classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function setText(id, value = '') {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = value ?? '';
        }
    }

    function updateSummary() {
        setText('summary-treatment', state.treatment ? `${state.treatment.name} · ${state.treatment.durationMinutes} min` : '—');
        setText('summary-date', state.date ? formatDateLabel(state.date) : '—');
        setText('summary-time', state.time ? slotLabels.get(state.time) ?? formatTime12h(state.time) : '—');
        setText('summary-cost', state.treatment ? `$${state.treatment.cost.toFixed(2)}` : '—');
    }

    function formatDateLabel(dateStr) {
        return new Date(`${dateStr}T00:00:00`).toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
    }

    function formatTime12h(timeStr) {
        const [hours, minutes] = timeStr.split(':').map(Number);
        const suffix = hours >= 12 ? 'PM' : 'AM';
        const hour12 = hours % 12 === 0 ? 12 : hours % 12;

        return `${hour12}:${String(minutes).padStart(2, '0')} ${suffix}`;
    }
}

initBookingPortal();

/**
 * Flash toasts: server-rendered session messages are enhanced with
 * auto-dismiss, and client-side actions (booking success, slot conflicts,
 * etc.) can push a toast through window.showToast().
 */
function dismissToast(toast) {
    toast.classList.add('translate-y-2', 'opacity-0');
    window.setTimeout(() => toast.remove(), 200);
}

function attachToastDismiss(toast) {
    let timer = window.setTimeout(() => dismissToast(toast), 6000);

    toast.querySelector('[data-flash-dismiss]')?.addEventListener('click', () => {
        window.clearTimeout(timer);
        dismissToast(toast);
    });
}

function showToast(message, tone = 'success') {
    if (!message) {
        return;
    }

    let container = document.getElementById('flash-toasts');

    if (!container) {
        container = document.createElement('div');
        container.id = 'flash-toasts';
        container.className =
            'pointer-events-none fixed right-4 top-20 z-[100] flex w-full max-w-sm flex-col gap-2';
        container.setAttribute('aria-live', 'polite');
        document.body.appendChild(container);
    }

    const isError = tone === 'error';
    const toast = document.createElement('div');
    toast.dataset.flashToast = '';
    toast.setAttribute('role', isError ? 'alert' : 'status');
    toast.className = `pointer-events-auto flex items-start gap-3 rounded-2xl border px-4 py-3.5 text-sm font-medium shadow-[0_18px_50px_rgba(60,61,66,0.14)] transition duration-200 ${
        isError ? 'border-[#e8b9aa] bg-[#fdf0eb] text-[#8f3e29]' : 'border-[#e2e3e4] bg-[#fef9ef] text-[#3c3d42]'
    }`;

    const dot = document.createElement('span');
    dot.className = `mt-0.5 size-2 shrink-0 rounded-full ${isError ? 'bg-[#c2714d]' : 'bg-[#3c3d42]'}`;
    dot.setAttribute('aria-hidden', 'true');

    const text = document.createElement('p');
    text.className = 'min-w-0 flex-1';
    text.textContent = message;

    const close = document.createElement('button');
    close.type = 'button';
    close.dataset.flashDismiss = '';
    close.className =
        '-mr-1 shrink-0 rounded-md p-0.5 text-base leading-none opacity-60 transition hover:opacity-100';
    close.setAttribute('aria-label', 'Dismiss notification');
    close.textContent = '×';

    toast.append(dot, text, close);
    container.appendChild(toast);

    attachToastDismiss(toast);
}

window.showToast = showToast;

function initFlashToasts() {
    document.querySelectorAll('[data-flash-toast]').forEach(attachToastDismiss);
}

initFlashToasts();

/**
 * Admin dashboard: mobile sidebar toggle.
 */
function initAdminLayout() {
    const sidebar = document.querySelector('[data-admin-sidebar]');
    const backdrop = document.querySelector('[data-admin-backdrop]');
    const toggle = document.querySelector('[data-admin-sidebar-toggle]');

    if (!sidebar || !backdrop || !toggle) {
        return;
    }

    const open = () => {
        sidebar.classList.remove('-translate-x-full');
        backdrop.hidden = false;
    };
    const close = () => {
        sidebar.classList.add('-translate-x-full');
        backdrop.hidden = true;
    };

    toggle.addEventListener('click', () => {
        sidebar.classList.contains('-translate-x-full') ? open() : close();
    });
    backdrop.addEventListener('click', close);
}

initAdminLayout();

/**
 * Admin dashboard: patient history modal. Opening any element with
 * [data-patient-history] fetches its data-history-url and renders the
 * patient's past appointments, notes and totals.
 */
function initPatientHistory() {
    const modal = document.getElementById('patient-history-modal');

    if (!modal) {
        return;
    }

    const body = modal.querySelector('[data-history-body]');
    const nameElement = modal.querySelector('[data-history-name]');
    const subtitleElement = modal.querySelector('[data-history-subtitle]');
    const loadingMarkup =
        '<div class="flex items-center justify-center gap-3 py-10 text-sm text-slate-500">' +
        '<span class="inline-block size-4 animate-spin rounded-full border-2 border-current border-t-transparent"></span>' +
        'Loading patient history…</div>';

    let controller = null;

    const open = () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    };

    const close = () => {
        controller?.abort();
        controller = null;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    };

    const escapeHtml = (value) =>
        String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');

    const statCard = (label, value) =>
        `<div class="rounded-xl bg-slate-50 p-3 ring-1 ring-slate-200">
            <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-500">${escapeHtml(label)}</p>
            <p class="mt-1 text-sm font-bold text-slate-900">${escapeHtml(value)}</p>
        </div>`;

    const renderHistory = (data) => {
        const patient = data.patient ?? {};
        const visits = data.appointments ?? [];
        const digits = String(patient.phone ?? '').replace(/\D+/g, '');

        nameElement.textContent = patient.name ?? 'Patient history';
        subtitleElement.textContent = [patient.phone, patient.age ? `${patient.age} years old` : null]
            .filter(Boolean)
            .join(' · ');

        const visitsMarkup = visits
            .map(
                (visit) => `<li class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                    <div class="flex flex-wrap items-start justify-between gap-2">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">${escapeHtml(visit.treatment ?? 'Treatment')}</p>
                            <p class="mt-0.5 text-xs text-slate-500">${escapeHtml(visit.date)} · ${escapeHtml(visit.time)} · ${escapeHtml(visit.duration_minutes ?? '—')} min</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-slate-700">$${escapeHtml(visit.cost ?? '0.00')}</span>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ${escapeHtml(visit.badge_class ?? '')}">${escapeHtml(visit.status_label ?? '')}</span>
                        </div>
                    </div>
                    <p class="mt-2 rounded-lg bg-white px-3 py-2 text-xs text-slate-600 ring-1 ring-slate-200">${
                        visit.notes ? escapeHtml(visit.notes) : '<span class="text-slate-400">No doctor notes for this visit.</span>'
                    }</p>
                </li>`
            )
            .join('');

        body.innerHTML = `
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                ${statCard('Visits', patient.total_visits ?? visits.length)}
                ${statCard('Completed', patient.completed_visits ?? 0)}
                ${statCard('Total paid', `$${patient.total_spent ?? '0.00'}`)}
                ${statCard('Last visit', patient.last_visit ?? '—')}
            </div>
            <div class="mt-5">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Appointment history</p>
                    ${digits ? `<a href="https://wa.me/${digits}" target="_blank" rel="noopener noreferrer" class="text-xs font-bold text-emerald-700 underline-offset-2 hover:underline">Message on WhatsApp</a>` : ''}
                </div>
                <ul class="mt-3 space-y-2.5">${visitsMarkup}</ul>
            </div>`;
    };

    document.addEventListener('click', async (event) => {
        const trigger = event.target.closest('[data-patient-history]');

        if (trigger) {
            open();
            nameElement.textContent = 'Patient history';
            subtitleElement.textContent = 'Loading…';
            body.innerHTML = loadingMarkup;

            controller?.abort();
            controller = new AbortController();

            try {
                const response = await fetch(trigger.dataset.historyUrl, {
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    signal: controller.signal,
                });

                if (!response.ok) {
                    throw new Error('Could not load patient history. Please try again.');
                }

                renderHistory(await response.json());
            } catch (error) {
                if (error.name === 'AbortError') {
                    return;
                }

                body.innerHTML = `<p class="py-10 text-center text-sm font-medium text-rose-600">${escapeHtml(error.message)}</p>`;
            }

            return;
        }

        if (event.target.closest('[data-history-close]') || event.target.closest('[data-history-backdrop]')) {
            close();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            close();
        }
    });
}

/**
 * Generic loading feedback: spinners + disabled state on form submit
 * buttons (filters, status updates, saves) and export-style links.
 */
function initLoadingStates() {
    const spinnerClasses =
        'inline-block size-3.5 animate-spin rounded-full border-2 border-current border-t-transparent align-[-2px] mr-1.5';

    document.addEventListener('submit', (event) => {
        const form = event.target;

        if (!(form instanceof HTMLFormElement)) {
            return;
        }

        // Defer so the browser dispatches the submission first.
        window.setTimeout(() => {
            form.querySelectorAll('button[type="submit"]').forEach((button) => {
                if (button.dataset.loadingApplied === 'true') {
                    return;
                }

                button.dataset.loadingApplied = 'true';
                button.disabled = true;
                button.classList.add('cursor-wait', 'opacity-80');

                const spinner = document.createElement('span');
                spinner.className = spinnerClasses;
                spinner.setAttribute('aria-hidden', 'true');
                button.prepend(spinner);
            });
        }, 0);
    });

    document.addEventListener('click', (event) => {
        const link = event.target.closest('[data-loading-link]');

        if (!link || link.dataset.loadingApplied === 'true') {
            return;
        }

        link.dataset.loadingApplied = 'true';
        link.classList.add('cursor-wait', 'opacity-80');

        const spinner = document.createElement('span');
        spinner.className = spinnerClasses;
        spinner.setAttribute('aria-hidden', 'true');
        link.prepend(spinner);

        window.setTimeout(() => {
            link.dataset.loadingApplied = 'false';
            link.classList.remove('cursor-wait', 'opacity-80');
            spinner.remove();
        }, 3000);
    });
}

/**
 * Admin dashboard: send WhatsApp templates in the background through
 * Whapi.cloud. Buttons carry their endpoint and template in data attributes;
 * success and failure are reported with the shared toast system.
 */
function initWhatsAppActions() {
    document.addEventListener('click', async (event) => {
        const button = event.target.closest('[data-whatsapp-send]');

        if (!button || button.disabled) {
            return;
        }

        const url = button.dataset.whatsappUrl;
        const template = button.dataset.whatsappTemplate;
        const label = button.querySelector('[data-whatsapp-label]');
        const originalLabel = label?.textContent ?? '';

        if (!url || !template) {
            showToast('The WhatsApp action is misconfigured. Please refresh the page.', 'error');
            return;
        }

        button.disabled = true;
        button.setAttribute('aria-busy', 'true');
        button.classList.add('cursor-wait', 'opacity-70');

        if (label) {
            label.textContent = 'Sending...';
        }

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') ?? '',
                },
                body: JSON.stringify({ template }),
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok || data.success !== true) {
                throw new Error(data.message ?? 'The WhatsApp message could not be sent.');
            }

            showToast(data.message ?? 'WhatsApp message sent successfully via Whapi!', 'success');
        } catch (error) {
            showToast(error.message || 'The WhatsApp message could not be sent.', 'error');
        } finally {
            button.disabled = false;
            button.removeAttribute('aria-busy');
            button.classList.remove('cursor-wait', 'opacity-70');

            if (label) {
                label.textContent = originalLabel;
            }
        }
    });
}

initWhatsAppActions();

initPatientHistory();
initLoadingStates();

/**
 * Public site: sticky header mobile drawer menu.
 */
function initSiteNav() {
    const toggle = document.querySelector('[data-site-nav-toggle]');
    const drawer = document.querySelector('[data-site-nav]');

    if (!toggle || !drawer) {
        return;
    }

    // Mobile-drawer open/close — handled by animations.js (GSAP) when available.
    // Fall back to plain class toggle only when GSAP hasn't loaded.
    if (typeof window.gsap === 'undefined') {
        toggle.addEventListener('click', () => {
            const isOpen = !drawer.classList.contains('hidden');
            drawer.classList.toggle('hidden', isOpen);
            toggle.setAttribute('aria-expanded', String(!isOpen));
        });
    }

    const menus = document.querySelectorAll('[data-site-menu]');

    if (menus.length > 0) {
        document.addEventListener('click', (event) => {
            menus.forEach((menu) => {
                if (!menu.contains(event.target)) {
                    menu.open = false;
                }
            });
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                menus.forEach((menu) => {
                    menu.open = false;
                });
            }
        });

        menus.forEach((menu) => {
            menu.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => {
                    menu.open = false;
                });
            });
        });
    }
}

initSiteNav();

/**
 * Patient dashboard: live "in 2d 3h" countdown for upcoming appointments.
 */
function initCountdowns() {
    const targets = document.querySelectorAll('[data-countdown-to]');

    if (targets.length === 0) {
        return;
    }

    const format = (startsAt) => {
        const diffMs = startsAt - Date.now();

        if (Number.isNaN(diffMs) || diffMs <= 0) {
            return 'starting soon';
        }

        const minutes = Math.floor(diffMs / 60000);
        const days = Math.floor(minutes / 1440);
        const hours = Math.floor((minutes % 1440) / 60);
        const mins = minutes % 60;

        if (days > 0) {
            return `in ${days}d ${hours}h`;
        }

        if (hours > 0) {
            return `in ${hours}h ${mins}m`;
        }

        if (minutes > 0) {
            return `in ${minutes}m`;
        }

        return 'starting soon';
    };

    const tick = () => {
        targets.forEach((element) => {
            const startsAt = new Date(element.dataset.countdownTo);

            if (Number.isNaN(startsAt.getTime())) {
                return;
            }

            element.textContent = format(startsAt);
        });
    };

    tick();
    window.setInterval(tick, 30000);
}

initCountdowns();

/**
 * Patient portal: reschedule appointment picker (date + live slot grid),
 * powered by the same availability engine as the public booking wizard.
 */
function initReschedulePicker() {
    const config = document.getElementById('reschedule-config');

    if (!config) {
        return;
    }

    const daysOff = config.dataset.daysOff
        .split(',')
        .filter((day) => day !== '')
        .map(Number);

    const elements = {
        dateInput: document.getElementById('reschedule-date-picker'),
        timeInput: document.getElementById('reschedule-time'),
        slotsMeta: document.getElementById('reschedule-slots-meta'),
        slotsGrid: document.getElementById('reschedule-slots-grid'),
        slotsLoading: document.getElementById('reschedule-slots-loading'),
        slotsEmpty: document.getElementById('reschedule-slots-empty'),
        slotsError: document.getElementById('reschedule-slots-error'),
        submitButton: document.getElementById('reschedule-submit'),
    };

    const slotLabels = new Map();
    let state = { date: null, time: null };
    let selectedSlotButton = null;

    flatpickr(elements.dateInput, {
        minDate: 'today',
        maxDate: config.dataset.maxDate,
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'l, F j, Y',
        disable: [(date) => daysOff.includes(date.getDay())],
        onChange: (selectedDates, dateStr) => {
            resetSlotSelection();
            state.date = dateStr || null;

            if (state.date) {
                loadSlots();
            } else {
                clearSlots();
            }
        },
    });

    function toggleHidden(element, shouldHide) {
        if (element) {
            element.hidden = shouldHide;
        }
    }

    function updateSubmitState() {
        if (elements.submitButton) {
            elements.submitButton.disabled = !state.time;
        }
    }

    function resetSlotSelection() {
        state.time = null;
        elements.timeInput.value = '';
        selectedSlotButton = null;
        updateSubmitState();
    }

    function clearSlots() {
        elements.slotsGrid.innerHTML = '';
        toggleHidden(elements.slotsGrid, true);
        toggleHidden(elements.slotsMeta, true);
        toggleHidden(elements.slotsEmpty, true);
        toggleHidden(elements.slotsError, true);
        toggleHidden(elements.slotsLoading, true);
    }

    async function loadSlots() {
        if (!state.date) {
            return;
        }

        const params = new URLSearchParams({ date: state.date });

        clearSlots();
        toggleHidden(elements.slotsLoading, false);

        try {
            const response = await fetch(`${config.dataset.slotsEndpoint}?${params}`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) {
                const data = await response.json().catch(() => ({}));
                throw new Error(data.message ?? 'Could not load available time slots.');
            }

            renderSlots(await response.json());
        } catch (error) {
            elements.slotsError.textContent = error.message;
            toggleHidden(elements.slotsError, false);
        } finally {
            toggleHidden(elements.slotsLoading, true);
        }
    }

    function renderSlots(data) {
        slotLabels.clear();

        if (data.day_off || data.slots.length === 0) {
            elements.slotsEmpty.textContent = data.day_off
                ? 'The clinic is closed on this date. Please pick another day.'
                : `There are no bookable slots on ${data.date_label}. Please pick another day.`;
            toggleHidden(elements.slotsEmpty, false);
            return;
        }

        data.slots.forEach((slot) => {
            slotLabels.set(slot.time, slot.label);

            const button = document.createElement('button');
            button.type = 'button';
            button.dataset.slot = slot.time;
            button.textContent = slot.label;

            if (slot.available) {
                button.className = `${SLOT_BASE_CLASSES} ${SLOT_AVAILABLE_CLASSES}`;
                button.addEventListener('click', () => selectSlot(button));
            } else {
                button.className = `${SLOT_BASE_CLASSES} ${SLOT_UNAVAILABLE_CLASSES}`;
                button.disabled = true;
            }

            elements.slotsGrid.appendChild(button);
        });

        elements.slotsMeta.textContent = data.available_count > 0
            ? `${data.available_count} of ${data.slots.length} time slots available on ${data.date_label}.`
            : `All slots for ${data.date_label} are already booked. Please pick another day.`;

        toggleHidden(elements.slotsMeta, false);
        toggleHidden(elements.slotsGrid, false);
    }

    function selectSlot(button) {
        if (selectedSlotButton) {
            selectedSlotButton.className = selectedSlotButton.dataset.restingClasses;
        }

        selectedSlotButton = button;
        button.dataset.restingClasses = button.className;
        button.className = `${SLOT_BASE_CLASSES} ${SLOT_SELECTED_CLASSES}`;

        state.time = button.dataset.slot;
        elements.timeInput.value = state.time;
        updateSubmitState();
    }

    updateSubmitState();
}

initReschedulePicker();
