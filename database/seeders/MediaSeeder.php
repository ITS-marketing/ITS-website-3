<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Zet de site-afbeeldingen (database/seeders/media, al verkleind naar web-formaat)
 * op de public disk onder media/. Pad blijft gelijk: seeders/media/certs/x.png -> media/certs/x.png
 */
class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $disk = Storage::disk('public');

        foreach (File::allFiles(database_path('seeders/media')) as $file) {
            $relative = 'media/'.str_replace('\\', '/', $file->getRelativePathname());

            if (! $disk->exists($relative)) {
                $disk->put($relative, File::get($file->getPathname()));
                $this->command?->line("  {$relative}");
            }
        }
    }
}
