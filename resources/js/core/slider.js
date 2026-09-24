// Horizontale scroll-slider (native overflow, dus swipe werkt vanzelf).
//   <div data-slider [data-slider-loop]>
//     <div data-slider-track class="flex overflow-x-auto no-scrollbar">…kaarten…</div>
//     <button data-slider-prev>   <button data-slider-next>
//     <div data-slider-dots="light|dark"></div>   -> dots worden door JS gegenereerd
//   </div>
// Stapgrootte = breedte eerste kaart + gap van de track.
export function initSliders(root = document) {
    root.querySelectorAll('[data-slider]').forEach((slider) => {
        const track = slider.querySelector('[data-slider-track]');
        const prev = slider.querySelector('[data-slider-prev]');
        const next = slider.querySelector('[data-slider-next]');
        const dotsEl = slider.querySelector('[data-slider-dots]');
        const loop = slider.hasAttribute('data-slider-loop');
        if (!track) return;

        const cards = () => [...track.children].filter((c) => !c.hasAttribute('data-slider-spacer'));
        let positions = 1;
        let index = 0;

        const step = () => {
            const first = cards()[0];
            if (!first) return 1;
            const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
            return first.getBoundingClientRect().width + gap;
        };

        const maxScroll = () => track.scrollWidth - track.clientWidth;

        const go = (i) => {
            index = Math.max(0, Math.min(i, positions - 1));
            const left = index === positions - 1 ? maxScroll() : index * step();
            track.scrollTo({ left, behavior: 'smooth' });
        };

        const renderDots = () => {
            if (!dotsEl) return;
            const light = dotsEl.dataset.sliderDots === 'light';
            dotsEl.innerHTML = '';
            for (let i = 0; i < positions; i++) {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.setAttribute('aria-label', `Ga naar ${i + 1}`);
                dot.className = 'h-2 rounded-full transition-all duration-300';
                dot.addEventListener('click', () => go(i));
                dotsEl.appendChild(dot);
            }
            dotsEl.dataset.light = light ? '1' : '';
        };

        const update = () => {
            const s = step();
            index = track.scrollLeft >= maxScroll() - 2 ? positions - 1 : Math.round(track.scrollLeft / s);
            if (prev) prev.disabled = index === 0;
            if (next) next.disabled = !loop && index >= positions - 1;
            if (dotsEl) {
                const light = dotsEl.dataset.light === '1';
                [...dotsEl.children].forEach((dot, i) => {
                    const active = i === index;
                    dot.style.width = active ? '24px' : '8px';
                    dot.style.background = active
                        ? light ? '#fff' : 'var(--its-primary)'
                        : light ? 'rgba(255,255,255,0.25)' : 'rgba(2,1,1,0.15)';
                });
            }
        };

        const measure = () => {
            const n = cards().length;
            positions = Math.min(Math.ceil(maxScroll() / step()), n - 1) + 1;
            if (!Number.isFinite(positions) || positions < 1) positions = 1;
            renderDots();
            update();
        };

        prev?.addEventListener('click', () => go(index - 1));
        next?.addEventListener('click', () => go(loop && index >= positions - 1 ? 0 : index + 1));

        let ticking = false;
        track.addEventListener('scroll', () => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(() => {
                update();
                ticking = false;
            });
        }, { passive: true });

        new ResizeObserver(measure).observe(track);
        measure();
    });
}
