{{--
    Blok 11: afsluitende CTA-kaart op foto.
    Wrapper: bovenste 30px wit, daaronder its-blue, zodat de afgeronde onderhoeken over de blauwe footer vallen.
    Bedoeld als laatste blok van de pagina.
--}}
@php
    $background = media_url($data['background_image'] ?? null);
    $icon = media_url($data['icon_image'] ?? null);
    $logos = array_filter($data['logos'] ?? [], fn ($l) => media_url($l['image'] ?? null));

    $showContact = (bool) ($data['show_contact'] ?? true);
    $phone = setting('contact.phone') ?: '010 30 31 930';
    $phoneLink = setting('contact.phone_link') ?: 'tel:+310103031930';
    $email = setting('contact.email') ?: 'hi@itsynergy.nl';
@endphp

<div style="background: linear-gradient(to bottom, white 30px, var(--its-blue) 30px)">
    <section
        @if (filled($data['anchor'] ?? null)) id="{{ $data['anchor'] }}" @endif
        class="relative overflow-hidden rounded-[30px] min-h-[480px] sm:min-h-[640px] flex items-center justify-center px-4 py-12 sm:px-6 sm:py-16 bg-its-primary"
    >
        @if ($background)
            <img
                src="{{ $background }}"
                alt=""
                class="absolute inset-0 w-full h-full object-cover"
                style="object-position: center 30%"
                loading="lazy"
                decoding="async"
            >
        @endif
        <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(0,114,204,0.50) 0%, rgba(0,114,204,0.05) 100%)" aria-hidden="true"></div>

        <div class="relative w-full max-w-xl 2xl:max-w-2xl rounded-3xl px-6 py-8 sm:px-12 sm:py-12 text-center shadow-2xl gradient-deep" data-fade>
            @if ($icon)
                <img
                    src="{{ $icon }}"
                    alt=""
                    class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl mx-auto mb-4 sm:mb-7 object-contain"
                    loading="lazy"
                    decoding="async"
                >
            @endif

            @if (filled($data['title'] ?? null))
                <h2 class="text-2xl sm:text-4xl 2xl:text-5xl font-bold leading-tight text-white">{!! nl_br($data['title']) !!}</h2>
            @endif

            @if (filled($data['body'] ?? null))
                <p class="mt-3 sm:mt-4 text-sm leading-relaxed text-white/60">{!! nl_br($data['body']) !!}</p>
            @endif

            @if (filled($data['button']['label'] ?? null) && filled($data['button']['url'] ?? null))
                <div class="mt-6 sm:mt-8">
                    <x-button :button="$data['button']" size="lg" class="w-full" />
                </div>
            @endif

            @if ($showContact)
                <div class="mt-4 sm:mt-6 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-xs">
                    <a href="{{ $phoneLink }}" class="text-white/55 hover:text-white transition-colors">
                        <span aria-hidden="true">📞</span> {{ $phone }}
                    </a>
                    <a href="mailto:{{ $email }}" class="text-white/55 hover:text-white transition-colors">
                        <span aria-hidden="true">✉️</span> {{ $email }}
                    </a>
                </div>
            @endif

            @if ($logos)
                <div class="border-t border-white/10 mt-6 sm:mt-8 pt-6 sm:pt-8 flex flex-wrap items-center justify-center gap-4 sm:gap-8">
                    @foreach ($logos as $logo)
                        <img
                            src="{{ media_url($logo['image']) }}"
                            alt="{{ $logo['alt'] ?? '' }}"
                            class="w-[88px] h-[52px] sm:w-[110px] sm:h-[64px] object-contain"
                            loading="lazy"
                            decoding="async"
                        >
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</div>
