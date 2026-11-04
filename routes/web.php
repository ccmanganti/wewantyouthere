<?php

use App\Http\Controllers\WeddingAuthController;
use App\Http\Controllers\WeddingBuilderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WeddingBuilderController::class, 'home'])->name('home');
Route::get('/templates/wedding/{slug}', [WeddingBuilderController::class, 'editor'])->name('wedding.editor');
Route::post('/templates/wedding/{slug}/publish', [WeddingBuilderController::class, 'publish'])
    ->middleware('throttle:12,1')->name('wedding.publish');

Route::get('/register', [WeddingAuthController::class, 'registration'])->name('wedding.register');
Route::post('/register', [WeddingAuthController::class, 'register'])->middleware('throttle:6,1')->name('wedding.register.submit');
Route::get('/login', [WeddingAuthController::class, 'loginForm'])->name('login');
Route::post('/login', [WeddingAuthController::class, 'login'])->middleware('throttle:6,1')->name('wedding.login.submit');
Route::post('/logout', [WeddingAuthController::class, 'logout'])->middleware('auth')->name('wedding.logout');

Route::get('/i/{slug}', [WeddingBuilderController::class, 'show'])->name('wedding.show');
