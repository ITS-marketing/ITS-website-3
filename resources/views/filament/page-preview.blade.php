{{-- Live preview naast de editor. Ververst na elke wijziging (zie EditPage::rendering). --}}
{{-- Inline styles: Filament's CSS is voorgecompileerd, eigen Tailwind-classes bestaan daar niet. --}}
<div
    wire:ignore
    x-data="{
        mobile: false,
        timer: null,
        reload() {
            const frame = this.$refs.frame;
            const y = frame.contentWindow?.scrollY ?? 0;
            frame.addEventListener('load', () => frame.contentWindow.scrollTo(0, y), { once: true });
            frame.contentWindow.location.reload();
        },
        init() {
            // Getypte tekst is 'deferred' in Livewire; na een korte pauze synchroniseren we zelf.
            // Op document-niveau: de blok-editor (slide-over) staat buiten deze component.
            document.addEventListener('input', () => {
                clearTimeout(this.timer);
                this.timer = setTimeout(() => $wire.$commit(), 700);
            });
        },
    }"
    x-on:page-preview-updated.window="reload()"
    style="position: sticky; top: 5rem; display: flex; flex-direction: column; gap: .5rem;"
>
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <span class="text-sm font-medium text-gray-950 dark:text-white">Live preview</span>
        <div style="display: flex; gap: .25rem;">
            <x-filament::button size="xs" color="gray" x-on:click="mobile = false">Desktop</x-filament::button>
            <x-filament::button size="xs" color="gray" x-on:click="mobile = true">Mobiel</x-filament::button>
            <x-filament::button size="xs" color="gray" icon="heroicon-m-arrow-path" x-on:click="reload()">Ververs</x-filament::button>
        </div>
    </div>

    <div style="overflow: hidden; border-radius: .75rem; border: 1px solid rgb(229 231 235); background: #fff;">
        <iframe
            x-ref="frame"
            src="{{ route('pages.preview', $this->record) }}"
            title="Preview"
            style="display: block; margin: 0 auto; height: calc(100vh - 11rem); border: 0; transition: width .2s;"
            x-bind:style="{ width: mobile ? '390px' : '100%' }"
        ></iframe>
    </div>
</div>
