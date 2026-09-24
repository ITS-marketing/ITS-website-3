// Accordion (één item tegelijk open).
//   <div data-accordion>
//     <div data-accordion-item [data-open]>
//       <button data-accordion-trigger>…</button>
//       <div data-accordion-panel><div>…</div></div>
//     </div>
//   </div>
// Open item heeft [data-open]; styling via Tailwind: group-data-[open]:…
export function initAccordion(root = document) {
    root.querySelectorAll('[data-accordion]').forEach((acc) => {
        const items = [...acc.querySelectorAll('[data-accordion-item]')];

        items.forEach((item) => {
            const trigger = item.querySelector('[data-accordion-trigger]');
            trigger?.setAttribute('aria-expanded', item.hasAttribute('data-open'));

            trigger?.addEventListener('click', () => {
                const open = !item.hasAttribute('data-open');
                items.forEach((other) => {
                    other.removeAttribute('data-open');
                    other.querySelector('[data-accordion-trigger]')?.setAttribute('aria-expanded', 'false');
                });
                if (open) {
                    item.setAttribute('data-open', '');
                    trigger.setAttribute('aria-expanded', 'true');
                }
            });
        });
    });
}
