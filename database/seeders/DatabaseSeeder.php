<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@it-synergy.test')],
            ['name' => 'Admin', 'password' => env('ADMIN_PASSWORD', 'password')],
        );

        $this->call([
            MediaSeeder::class,
            SettingsSeeder::class,
            HomePageSeeder::class,
        ]);
    }
}
