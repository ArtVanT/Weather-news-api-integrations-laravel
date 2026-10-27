<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiViewController;

Route::get('/', [ApiViewController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
