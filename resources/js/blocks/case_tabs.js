// Klantcases: quote "line reveal" per woord afspelen zodra de kaart in beeld komt
// en opnieuw bij elke tabwissel (event 'tabs:change' van core/tabs.js).
// De animatie hangt aan [data-reveal] op de blockquote (group-data-[reveal]:animate-…).
export default function (root) {
    root.querySelectorAll('[data-case-tabs]').forEach((tabs) => {
        const quotes = [...tabs.querySelectorAll('[data-quote]')];
        if (!quotes.length) return;

        const replay = (quote) => {
            if (!quote) return;
            quote.removeAttribute('data-reveal');
            void quote.offsetWidth; // reflow, zodat de animatie opnieuw start
            quote.setAttribute('data-reveal', '');
        };

        const activeQuote = () =>
            tabs.querySelector('[data-tab-panel]:not([hidden]) [data-quote]');

        // Pas afspelen als het blok in beeld komt.
        if ('IntersectionObserver' in window) {
            quotes.forEach((q) => q.removeAttribute('data-reveal'));
            const observer = new IntersectionObserver(
                (entries) => {
                    if (!entries.some((e) => e.isIntersecting)) return;
                    observer.disconnect();
                    quotes.forEach((q) => q.setAttribute('data-reveal', ''));
                },
                { rootMargin: '0px 0px -150px 0px' },
            );
            observer.observe(tabs);
        }

        tabs.addEventListener('tabs:change', () => replay(activeQuote()));
    });
}
