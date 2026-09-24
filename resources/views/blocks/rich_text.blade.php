{{-- Generiek: tekstblok (rich text) --}}
@php
    $narrow = ($data['width'] ?? 'narrow') !== 'wide';
    $hasBody = filled(strip_tags($data['body'] ?? ''));
@endphp

<section
    @if (filled($data['anchor'] ?? null)) id="{{ $data['anchor'] }}" @endif
    class="bg-white py-12 sm:py-16 2xl:py-20"
>
    <x-container>
        <div @class(['max-w-3xl mx-auto' => $narrow]) data-fade>
            @if (filled($data['title'] ?? null))
                <x-heading :data="$data" />
            @endif

            @if ($hasBody)
                <div @class([
                    'prose-its text-base leading-relaxed text-[#020101]/70 [&>*:first-child]:mt-0 [&>*:last-child]:mb-0',
                    'mt-5 sm:mt-6' => filled($data['title'] ?? null),
                ])>
                    {!! $data['body'] !!}
                </div>
            @endif
        </div>
    </x-container>
</section>
