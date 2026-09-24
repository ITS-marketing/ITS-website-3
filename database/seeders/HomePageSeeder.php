<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

/**
 * Bouwt de homepage op uit database/seeders/blocks/{type}.php, in de volgorde van het origineel.
 */
class HomePageSeeder extends Seeder
{
    public const BLOCKS = [
        'hero',
        'logo_marquee',
        'audience_tabs',
        'promo_banner',
        'services_filter',
        'process_slider',
        'case_tabs',
        'certs_partners',
        'card_slider',
        'faq',
        'cta_card',
    ];

    public function run(): void
    {
        $blocks = collect(self::BLOCKS)
            ->map(fn (string $type) => database_path("seeders/blocks/{$type}.php"))
            ->filter(fn (string $file) => file_exists($file))
            ->map(fn (string $file) => require $file)
            ->values()
            ->all();

        Page::updateOrCreate(['slug' => 'home'], [
            'title' => 'Home',
            'blocks' => $blocks,
            'is_published' => true,
            'is_home' => true,
        ]);

        $this->command?->info('Homepage: '.count($blocks).' blokken.');
    }
}
