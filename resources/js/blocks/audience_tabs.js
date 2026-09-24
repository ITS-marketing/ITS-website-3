// Roterend woord in de titel (blok audience_tabs).
//   <span data-rotating-word data-words='["a","b"]' data-interval="2800">a</span>
// Fade-out 300ms (opacity 0 + translateY(-8px)), dan het volgende woord terug.
export default function (root) {
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    root.querySelectorAll('[data-rotating-word]').forEach((el) => {
        if (el.dataset.rotatingInit) return;
        el.dataset.rotatingInit = '1';

        let words = [];
        try {
            words = JSON.parse(el.dataset.words || '[]');
        } catch {
            return;
        }
        if (words.length < 2) return;

        const interval = Math.max(1000, parseInt(el.dataset.interval, 10) || 2800);
        let i = 0;

        setInterval(() => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-8px)';
            setTimeout(
                () => {
                    i = (i + 1) % words.length;
                    el.textContent = words[i];
                    el.style.opacity = '';
                    el.style.transform = '';
                },
                reduce ? 0 : 300,
            );
        }, interval);
    });
}
