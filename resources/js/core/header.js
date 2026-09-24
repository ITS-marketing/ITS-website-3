// Header: scroll-state, mega menu (hover), taalkeuze, hoog contrast en mobiel menu.
export function initHeader() {
    const header = document.querySelector('[data-header]');
    if (!header) return;

    // Topbar inklappen zodra er gescrold wordt.
    const onScroll = () => header.toggleAttribute('data-scrolled', window.scrollY >= 8);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    initMegaMenu(header);
    initLanguage(header);
    initContrast(header);
    initMobileMenu(header);
}

function initMegaMenu(header) {
    const triggers = [...header.querySelectorAll('[data-mega-trigger]')];
    const panels = [...header.querySelectorAll('[data-mega-panel]')];
    let closeTimer = null;
    let openKey = null;

    const open = (key) => {
        clearTimeout(closeTimer);
        openKey = key;
        triggers.forEach((t) => {
            const active = t.dataset.megaTrigger === key;
            t.toggleAttribute('data-open', active);
            t.setAttribute('aria-expanded', active);
        });
        panels.forEach((p) => (p.hidden = p.dataset.megaPanel !== key));
    };

    const close = () => {
        openKey = null;
        triggers.forEach((t) => {
            t.removeAttribute('data-open');
            t.setAttribute('aria-expanded', 'false');
        });
        panels.forEach((p) => (p.hidden = true));
    };

    const scheduleClose = () => {
        clearTimeout(closeTimer);
        closeTimer = setTimeout(close, 120);
    };

    triggers.forEach((t) => {
        t.addEventListener('mouseenter', () => open(t.dataset.megaTrigger));
        t.addEventListener('mouseleave', scheduleClose);
        // Toetsenbord: pijl omlaag opent het panel.
        t.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                open(t.dataset.megaTrigger);
                header.querySelector(`[data-mega-panel="${t.dataset.megaTrigger}"] a`)?.focus();
            }
        });
    });

    panels.forEach((p) => {
        p.addEventListener('mouseenter', () => clearTimeout(closeTimer));
        p.addEventListener('mouseleave', scheduleClose);
        p.addEventListener('focusout', (e) => {
            if (!p.contains(e.relatedTarget)) scheduleClose();
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && openKey !== null) {
            header.querySelector(`[data-mega-trigger="${openKey}"]`)?.focus();
            close();
        }
    });
}

function initLanguage(header) {
    const toggle = header.querySelector('[data-lang-toggle]');
    const menu = header.querySelector('[data-lang-menu]');
    if (!toggle || !menu) return;

    const set = (open) => {
        menu.hidden = !open;
        toggle.setAttribute('aria-expanded', open);
    };

    toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        set(menu.hidden);
    });
    document.addEventListener('click', (e) => {
        if (!menu.contains(e.target)) set(false);
    });
}

function initContrast(header) {
    const toggle = header.querySelector('[data-contrast-toggle]');
    if (!toggle) return;

    const root = document.documentElement;
    toggle.setAttribute('aria-pressed', root.hasAttribute('data-hc'));

    toggle.addEventListener('click', () => {
        const on = !root.hasAttribute('data-hc');
        root.toggleAttribute('data-hc', on);
        toggle.setAttribute('aria-pressed', on);
        try {
            on ? localStorage.setItem('hc', '1') : localStorage.removeItem('hc');
        } catch (e) {}
    });
}

function initMobileMenu(header) {
    const toggle = header.querySelector('[data-menu-toggle]');
    const menu = header.querySelector('[data-mobile-menu]');
    if (!toggle || !menu) return;

    const set = (open) => {
        menu.hidden = !open;
        toggle.setAttribute('aria-expanded', open);
        toggle.setAttribute('aria-label', open ? 'Menu sluiten' : 'Menu openen');
    };

    toggle.addEventListener('click', () => set(menu.hidden));
    menu.addEventListener('click', (e) => {
        if (e.target.closest('a')) set(false);
    });
}
