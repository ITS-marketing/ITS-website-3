import { initFadeIn } from './core/fade-in';
import { initTabs } from './core/tabs';
import { initAccordion } from './core/accordion';
import { initSliders } from './core/slider';
import { initHeader } from './core/header';

// Blok-specifieke scripts: elk bestand in ./blocks exporteert een `default function (root)`.
const blockScripts = import.meta.glob('./blocks/*.js', { eager: true });

function boot() {
    initHeader();
    initTabs();
    initAccordion();
    initSliders();
    Object.values(blockScripts).forEach((mod) => mod.default?.(document));
    initFadeIn();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}
