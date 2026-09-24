// Scroll fade-in.
//   [data-fade]           -> element fade't in (optioneel style="--d: .2s" als delay)
//   [data-fade-stagger]   -> kinderen faden na elkaar in (0.1s stap)
export function initFadeIn(root = document) {
    const els = root.querySelectorAll('[data-fade]:not(.is-visible), [data-fade-stagger]:not(.is-visible)');
    if (!els.length) return;

    els.forEach((el) => {
        if (!el.hasAttribute('data-fade-stagger')) return;
        [...el.children].forEach((child, i) => child.style.setProperty('--d', `${0.05 + i * 0.1}s`));
    });

    if (!('IntersectionObserver' in window)) {
        els.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        { rootMargin: '0px 0px -150px 0px' },
    );

    els.forEach((el) => observer.observe(el));
}
