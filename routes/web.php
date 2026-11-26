<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Masuk tanpa kata sandi lewat tautan email
Route::middleware('guest')->group(function () {
    Route::get('login-link', [\App\Http\Controllers\Auth\MagicLinkController::class, 'create'])->name('login.link');
    Route::post('login-link', [\App\Http\Controllers\Auth\MagicLinkController::class, 'store'])->middleware('throttle:5,1')->name('login.link.send');
    Route::get('login-link/{user}', [\App\Http\Controllers\Auth\MagicLinkController::class, 'login'])->middleware('signed')->name('login.link.verify');
});
