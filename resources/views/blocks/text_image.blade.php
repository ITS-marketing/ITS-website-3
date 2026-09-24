{{-- Generiek: tekst + afbeelding (subpagina's) --}}
@php
    $image = media_url($data['image'] ?? null);
    $bullets = array_filter($data['bullets'] ?? [], 'filled');
    $gray = ($data['background'] ?? 'white') === 'gray';
    $imageLeft = ($data['image_position'] ?? 'right') === 'left';
    $hasButtons = filled($data['button']['label'] ?? null) || filled($data['secondary_button']['label'] ?? null);
@endphp

<section
    @if (filled($data['anchor'] ?? null)) id="{{ $data['anchor'] }}" @endif
    @class([
        'py-16 sm:py-20 lg:py-20 2xl:py-28',
        'bg-[#F5F5F7] rounded-[30px]' => $gray,
        'bg-white' => ! $gray,
    ])
>
    <x-container>
        <div @class(['grid gap-8 sm:gap-10 lg:gap-16 items-center', 'lg:grid-cols-2' => $image])>
            <div @class(['max-w-2xl', 'lg:order-last' => $image && $imageLeft]) data-fade>
                @if (filled($data['title'] ?? null))
                    <x-heading :data="$data" />
                @endif

                @if (filled(strip_tags($data['body'] ?? '')))
                    <div class="prose-its mt-4 sm:mt-5 text-base leading-relaxed text-[#020101]/60 [&>*:last-child]:mb-0">
                        {!! $data['body'] !!}
                    </div>
                @endif

                @if ($bullets)
                    <ul class="mt-5 space-y-2.5">
                        @foreach ($bullets as $bullet)
                            <li class="flex items-start gap-2.5 text-sm text-[#020101]/70">
                                <span aria-hidden="true">✅</span>
                                <span>{{ $bullet }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($hasButtons)
                    <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-5">
                        <x-button :button="$data['button'] ?? null" />
                        <x-button :button="$data['secondary_button'] ?? null" variant="link" />
                    </div>
                @endif
            </div>

            @if ($image)
                <div data-fade style="--d:.1s">
                    <img
                        src="{{ $image }}"
                        alt="{{ $data['image_alt'] ?? '' }}"
                        class="w-full aspect-[4/3] object-cover rounded-3xl shadow-lg"
                        loading="lazy"
                        decoding="async"
                    >
                </div>
            @endif
        </div>
    </x-container>
</section>
