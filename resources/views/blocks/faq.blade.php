{{-- Blok 10: FAQ-accordion (+ FAQPage JSON-LD) --}}
@php
    $items = array_values(array_filter($data['items'] ?? [], fn ($item) => filled($item['question'] ?? null)));
    $firstOpen = (bool) ($data['first_open'] ?? true);

    $jsonLd = null;
    if (($data['schema'] ?? true) && $items) {
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($item) => [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => trim(html_entity_decode(strip_tags((string) ($item['answer'] ?? '')), ENT_QUOTES | ENT_HTML5, 'UTF-8')),
                ],
            ], $items),
        ];
    }
@endphp

<section
    @if (filled($data['anchor'] ?? null)) id="{{ $data['anchor'] }}" @endif
    class="bg-white pt-4 pb-20 sm:pb-28 lg:pb-24 2xl:pb-36"
>
    <x-container>
        @if (filled($data['title'] ?? null) || filled($data['button']['label'] ?? null))
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 sm:gap-6 mb-6 sm:mb-12" data-fade>
                <div class="max-w-xl">
                    <x-heading :data="$data" />
                </div>
                <x-button :button="$data['button'] ?? null" class="self-start lg:self-auto shrink-0" />
            </div>
        @endif

        @if ($items)
            <div class="flex flex-col gap-3" data-accordion data-fade-stagger>
                @foreach ($items as $i => $item)
                    @php $id = 'faq-'.($index ?? 0).'-'.$i; @endphp
                    <div
                        data-accordion-item
                        @if ($firstOpen && $i === 0) data-open @endif
                        class="group rounded-2xl overflow-hidden border transition-colors duration-200 border-[#D5D5D5]/50 bg-[#F5F5F7] data-[open]:border-its-primary/20 data-[open]:bg-its-sky"
                    >
                        <h3>
                        <button
                            type="button"
                            id="{{ $id }}-trigger"
                            aria-controls="{{ $id }}-panel"
                            aria-expanded="{{ $firstOpen && $i === 0 ? 'true' : 'false' }}"
                            data-accordion-trigger
                            class="w-full flex items-center justify-between gap-3 sm:gap-4 px-4 py-3.5 sm:px-6 sm:py-5 text-left"
                        >
                            <span class="font-semibold text-base text-its-dark group-data-[open]:text-its-primary transition-colors duration-200">{{ $item['question'] }}</span>
                            <x-lucide name="chevron-down" size="18" class="text-its-primary transition-transform duration-300 group-data-[open]:rotate-180" />
                        </button>
                        </h3>
                        <div data-accordion-panel id="{{ $id }}-panel" role="region" aria-labelledby="{{ $id }}-trigger">
                            <div>
                                <div class="prose-its px-4 pb-4 sm:px-6 sm:pb-6 text-[#020101]/65 text-sm leading-relaxed [&>*:last-child]:mb-0">
                                    {!! $item['answer'] ?? '' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-container>

    @if ($jsonLd)
        <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
    @endif
</section>
