'use strict';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.client-modal-filters').forEach((root, index) => {
        const toggle = root.querySelector('.directorist-modal-btn--advanced');
        const panel = root.querySelector('.directorist-search-modal--advanced');
        const close = panel?.querySelector('.directorist-search-modal__contents__btn--close');
        if (!toggle || !panel) return;

        panel.id = `client-modal-advanced-${index}`;
        toggle.setAttribute('role', 'button');
        toggle.setAttribute('aria-controls', panel.id);
        const setOpen = (open, restoreFocus = false) => {
            panel.hidden = !open;
            toggle.setAttribute('aria-expanded', String(open));
            if (restoreFocus) toggle.focus({preventScroll: true});
        };
        setOpen(false);

        // Keep the advanced fields in the original form, inside the existing dialog.
        // Stop the native delegated handler from opening a second overlapping modal.
        root.addEventListener('click', (event) => {
            const reset = event.target.closest('.directorist-btn-reset-js');
            if (reset) {
                event.preventDefault();
                event.stopImmediatePropagation();
                const form = reset.closest('form');
                form?.reset();
                form?.querySelectorAll('input, select, textarea').forEach((field) => {
                    if (window.jQuery && field.matches('select')) {
                        window.jQuery(field).trigger('change');
                    } else {
                        field.dispatchEvent(new Event('input', {bubbles: true}));
                        field.dispatchEvent(new Event('change', {bubbles: true}));
                    }
                });
                return;
            }
            if (toggle.contains(event.target) || close?.contains(event.target)) {
                event.preventDefault();
                event.stopImmediatePropagation();
                setOpen(toggle.contains(event.target) ? panel.hidden : false, close?.contains(event.target));
            }
        }, true);

        root.addEventListener('keydown', (event) => {
            if (event.key === ' ' && toggle.contains(event.target)) {
                event.preventDefault();
                toggle.click();
            }
        });

        const popup = root.closest('.directorist-search-popup-block__popup');
        popup?.classList.add('client-filters-popup');
        // Capture Escape before the parent popup's document handler.
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && popup?.classList.contains('show') && !panel.hidden) {
                event.preventDefault();
                event.stopImmediatePropagation();
                setOpen(false, true);
            }
        }, true);
        popup?.querySelector('.directorist-search-popup-block__form-close')?.addEventListener('click', () => setOpen(false));
    });
});
