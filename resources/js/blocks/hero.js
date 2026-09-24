// Hero: parallax-achtergrond, "Scroll verder"-knop, doorlopende fotostrip en video-modal.
const reducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

export default function (root) {
    root.querySelectorAll('[data-hero]').forEach((hero) => {
        initScroll(hero);
        initStrip(hero);
        initVideoModal(hero);
    });
}

function initScroll(hero) {
    const parallax = hero.querySelector('[data-hero-parallax]');
    const scrollBtn = hero.querySelector('[data-hero-scroll]');
    if (!parallax && !scrollBtn) return;

    let ticking = false;
    const update = () => {
        ticking = false;
        const y = window.scrollY;
        if (parallax && !reducedMotion() && y < hero.offsetTop + hero.offsetHeight) {
            parallax.style.transform = `translate3d(0, ${(y * 0.08).toFixed(2)}px, 0)`;
        }
        scrollBtn?.toggleAttribute('data-hidden', y > 16);
    };

    window.addEventListener('scroll', () => {
        if (!ticking) {
            ticking = true;
            requestAnimationFrame(update);
        }
    }, { passive: true });
    update();

    scrollBtn?.addEventListener('click', () => {
        window.scrollTo({ top: window.innerHeight, behavior: reducedMotion() ? 'auto' : 'smooth' });
    });
}

function initStrip(hero) {
    const viewport = hero.querySelector('[data-hero-strip]');
    const track = viewport?.querySelector('[data-hero-strip-track]');
    const clone = track?.querySelector('[data-hero-strip-clone]');
    const speed = parseFloat(viewport?.dataset.speed ?? '0.7');
    if (!track || !clone || !(speed > 0) || reducedMotion()) return;

    // Vanaf hier animeren: kopie tonen, handmatig scrollen uit.
    clone.hidden = false;
    viewport.classList.replace('overflow-x-auto', 'overflow-hidden');

    const first = track.firstElementChild;
    let loopWidth = 0;
    const measure = () => { loopWidth = clone.offsetLeft - first.offsetLeft; };
    measure();
    window.addEventListener('resize', measure, { passive: true });

    let offset = 0;
    let last = 0;
    let hovered = false;
    let visible = true;
    let running = false;

    const frame = (now) => {
        if (hovered || !visible || hero.hasAttribute('data-modal-open')) {
            running = false;
            return;
        }
        // 0.7px per frame bij 60fps, ongeacht de verversingssnelheid van het scherm.
        const dt = last ? Math.min(now - last, 50) : 16.67;
        last = now;
        offset += speed * (dt / 16.67);
        if (loopWidth > 0 && offset >= loopWidth) offset -= loopWidth;
        track.style.transform = `translate3d(${-offset}px, 0, 0)`;
        requestAnimationFrame(frame);
    };

    const start = () => {
        if (running || hovered || !visible) return;
        running = true;
        last = 0;
        requestAnimationFrame(frame);
    };

    track.addEventListener('pointerenter', (e) => { if (e.pointerType === 'mouse') { hovered = true; } });
    track.addEventListener('pointerleave', () => { hovered = false; start(); });
    track.addEventListener('focusin', () => { hovered = true; });
    track.addEventListener('focusout', () => { hovered = false; start(); });
    hero.addEventListener('hero:resume', start);

    if ('IntersectionObserver' in window) {
        new IntersectionObserver(([entry]) => {
            visible = entry.isIntersecting;
            start();
        }).observe(viewport);
    }

    start();
}

function initVideoModal(hero) {
    const modal = hero.querySelector('[data-hero-modal]');
    if (!modal || typeof modal.showModal !== 'function') return;

    const frame = modal.querySelector('[data-hero-modal-frame]');
    const placeholder = modal.querySelector('[data-hero-modal-placeholder]');

    hero.querySelectorAll('[data-hero-video]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const src = btn.dataset.heroVideo;
            const kind = btn.dataset.heroVideoKind;
            frame.replaceChildren();

            if (src && kind === 'iframe') {
                const iframe = document.createElement('iframe');
                iframe.src = src;
                iframe.title = btn.getAttribute('aria-label') || 'Video';
                iframe.allow = 'autoplay; fullscreen; picture-in-picture; encrypted-media';
                iframe.allowFullscreen = true;
                iframe.className = 'size-full border-0';
                frame.append(iframe);
            } else if (src && kind === 'file') {
                const video = document.createElement('video');
                video.src = src;
                video.controls = true;
                video.autoplay = true;
                video.playsInline = true;
                video.className = 'size-full object-contain bg-black';
                frame.append(video);
            }

            placeholder.hidden = frame.childElementCount > 0;
            hero.setAttribute('data-modal-open', '');
            document.documentElement.style.overflow = 'hidden';
            modal.showModal();
        });
    });

    modal.querySelector('[data-hero-modal-close]')?.addEventListener('click', () => modal.close());
    // Klik naast de video (op de donkere overlay) sluit.
    modal.addEventListener('click', (e) => { if (e.target === modal) modal.close(); });
    modal.addEventListener('close', () => {
        frame.replaceChildren();
        document.documentElement.style.overflow = '';
        hero.removeAttribute('data-modal-open');
        hero.dispatchEvent(new CustomEvent('hero:resume'));
    });
}
