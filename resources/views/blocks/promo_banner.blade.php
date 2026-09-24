{{-- Blok 04: promo-/webinarbanner --}}
@php
    $image = media_url($data['image'] ?? null);
    $imageRight = ($data['image_position'] ?? 'left') === 'right';
@endphp

<section @if (filled($data['anchor'] ?? null)) id="{{ $data['anchor'] }}" @endif class="bg-white py-6">
    <x-container>
        <div class="gradient-secondary rounded-3xl overflow-hidden flex flex-col lg:flex-row" data-fade>
            @if ($image)
                <div @class(['relative lg:w-[42%] shrink-0 min-h-[160px] sm:min-h-[220px]', 'lg:order-2' => $imageRight])>
                    <img
                        src="{{ $image }}"
                        alt="{{ $data['image_alt'] ?? '' }}"
                        loading="lazy"
                        decoding="async"
                        class="absolute inset-0 w-full h-full object-cover"
                    >
                </div>
            @endif

            <div class="flex-1 flex flex-col justify-center px-5 py-6 sm:px-8 sm:py-9 2xl:py-10">
                @if (filled($data['eyebrow'] ?? null))
                    <p class="text-[10px] sm:text-xs font-semibold tracking-wide text-its-primary mb-2">{{ $data['eyebrow'] }}</p>
                @endif
                @if (filled($data['title'] ?? null))
                    <h2 class="text-[18px] sm:text-2xl font-bold text-white leading-snug mb-2">{!! nl_br($data['title']) !!}</h2>
                @endif
                @if (filled($data['body'] ?? null))
                    <p class="text-white/60 text-[12px] sm:text-sm leading-relaxed max-w-xl">{!! nl_br($data['body']) !!}</p>
                @endif

                @if (filled($data['button']['label'] ?? null) || filled($data['secondary_button']['label'] ?? null))
                    <div class="flex flex-wrap items-center gap-4 sm:gap-6 mt-5 sm:mt-6">
                        <x-button :button="$data['button'] ?? null" icon="monitor" />
                        <x-button :button="$data['secondary_button'] ?? null" variant="link" />
                    </div>
                @endif
            </div>
        </div>
    </x-container>
</section>
