{{-- Standaard content-container (max 1440px). --}}
<div {{ $attributes->merge(['class' => 'max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-[120px] 2xl:px-8']) }}>
    {{ $slot }}
</div>
