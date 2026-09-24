<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/pages/{page}/preview', [PageController::class, 'preview'])
    ->middleware('auth')
    ->name('pages.preview');

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '^(?!admin|livewire|storage|filament|build).*$')
    ->name('page');
