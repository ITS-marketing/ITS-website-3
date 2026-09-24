// Generieke tabs.
//   <div data-tabs>
//     <button data-tab="a">…</button>            actieve knop krijgt [data-active] + aria-selected
//     <div data-tab-panel="a">…</div>            inactieve panelen krijgen [hidden]
//   </div>
// De eerste knop met [data-active] in de HTML is de start-tab (anders de eerste).
// Event: 'tabs:change' op [data-tabs] met detail { key }.
export function initTabs(root = document) {
    root.querySelectorAll('[data-tabs]').forEach((tabs) => {
        const own = (el) => el.closest('[data-tabs]') === tabs;
        const buttons = [...tabs.querySelectorAll('[data-tab]')].filter(own);
        const panels = [...tabs.querySelectorAll('[data-tab-panel]')].filter(own);

        const activate = (key, emit = true) => {
            buttons.forEach((b) => {
                const active = b.dataset.tab === key;
                b.toggleAttribute('data-active', active);
                b.setAttribute('aria-selected', active);
            });
            panels.forEach((p) => {
                const active = p.dataset.tabPanel === key;
                p.hidden = !active;
                if (active) {
                    // Fade-in opnieuw afspelen voor de nieuwe inhoud.
                    p.querySelectorAll('[data-fade-stagger], [data-fade]').forEach((el) => el.classList.add('is-visible'));
                }
            });
            if (emit) tabs.dispatchEvent(new CustomEvent('tabs:change', { detail: { key } }));
        };

        buttons.forEach((b) => {
            b.setAttribute('role', 'tab');
            b.addEventListener('click', () => activate(b.dataset.tab));
        });

        const start = buttons.find((b) => b.hasAttribute('data-active')) ?? buttons[0];
        if (start) activate(start.dataset.tab, false);
    });
}
