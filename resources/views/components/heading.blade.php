{{--
    Sectiekop: eyebrow + H2 + intro. Leest $data['eyebrow'|'title'|'intro'] (zie App\Blocks\Fields::heading()).
    <x-heading :data="$data" align="center" :dark="true" />
    Eigen titel-markup kan via de slot "title".
--}}
@props(['data' => [], 'align' => 'left', 'dark' => false, 'as' => 'h2'])

<div {{ $attributes->class([
    'text-center mx-auto' => $align === 'center',
    'max-w-2xl' => $align !== 'center',
]) }}>
    @if (filled($data['eyebrow'] ?? null))
        <p @class([
            'text-[10px] sm:text-xs font-semibold tracking-wide mb-2 sm:mb-3',
            'text-white/40' => $dark,
            'text-[#020101]/35' => ! $dark,
        ])>{{ $data['eyebrow'] }}</p>
    @endif

    <{{ $as }} @class([
        'text-2xl sm:text-4xl 2xl:text-5xl font-bold leading-tight',
        'text-white' => $dark,
        'text-its-primary' => ! $dark,
    ])>
        @isset($title)
            {{ $title }}
        @else
            {!! nl_br($data['title'] ?? '') !!}
        @endisset
    </{{ $as }}>

    @if (filled($data['intro'] ?? null))
        <p @class([
            'mt-3 sm:mt-4 text-base leading-relaxed',
            'text-white/60' => $dark,
            'text-[#020101]/60' => ! $dark,
        ])>{!! nl_br($data['intro']) !!}</p>
    @endif
</div>
