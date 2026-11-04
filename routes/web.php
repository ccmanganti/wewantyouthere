<?php

use App\Http\Controllers\WeddingAuthController;
use App\Http\Controllers\WeddingBuilderController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\WeddingPhotoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WeddingBuilderController::class, 'home'])->name('home');
Route::get('/wedding-invitation-templates', [MarketingController::class, 'templates'])->name('marketing.templates');
Route::get('/wedding-invitation-templates/{slug}', [MarketingController::class, 'templateDetail'])
    ->where('slug', '[a-z0-9-]+')->name('marketing.templateDetail');
Route::get('/templates/{slug}/preview', [MarketingController::class, 'templatePreview'])
    ->where('slug', '[a-z0-9-]+')->name('marketing.templatePreview');
Route::get('/privacy', fn () => app(MarketingController::class)->legal('privacy'))->name('marketing.privacy');
Route::get('/terms', fn () => app(MarketingController::class)->legal('terms'))->name('marketing.terms');
Route::get('/sitemap.xml', [MarketingController::class, 'sitemap'])->name('marketing.sitemap');
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])
    ->middleware('throttle:20,1')->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->middleware('throttle:20,1')->name('auth.google.callback');
Route::get('/robots.txt', [MarketingController::class, 'robots'])->name('marketing.robots');
Route::post('/templates/wedding/{slug}/photos', [WeddingPhotoController::class, 'upload'])
    ->middleware('throttle:16,1')->name('wedding.photos.upload');
Route::get('/templates/wedding/{slug}/photos/{slot}', [WeddingPhotoController::class, 'draft'])
    ->name('wedding.photos.draft');
Route::delete('/templates/wedding/{slug}/photos/{slot}', [WeddingPhotoController::class, 'removeDraft'])
    ->middleware('throttle:30,1')->name('wedding.photos.removeDraft');
Route::middleware('auth')->group(function () {
    Route::get('/app/invitations/{website}/photos', [WeddingPhotoController::class, 'manage'])
        ->name('wedding.photos.manage');
    Route::post('/app/invitations/{website}/photos', [WeddingPhotoController::class, 'replace'])
        ->middleware('throttle:16,1')->name('wedding.photos.replace');
    Route::delete('/app/invitations/{website}/photos/{slot}', [WeddingPhotoController::class, 'remove'])
        ->name('wedding.photos.remove');
});
Route::get('/i/{slug}/photos/{slot}', [WeddingPhotoController::class, 'publicPhoto'])
    ->name('wedding.photos.site');
Route::get('/templates/wedding/{slug}', [WeddingBuilderController::class, 'editor'])->name('wedding.editor');
Route::post('/templates/wedding/{slug}/cancel', [WeddingBuilderController::class, 'cancel'])->name('wedding.cancel');
Route::post('/templates/wedding/{slug}/publish', [WeddingBuilderController::class, 'publish'])
    ->middleware('throttle:12,1')->name('wedding.publish');

Route::get('/register', [WeddingAuthController::class, 'registration'])->name('wedding.register');
Route::post('/register', [WeddingAuthController::class, 'register'])->middleware('throttle:6,1')->name('wedding.register.submit');
Route::get('/login', [WeddingAuthController::class, 'loginForm'])->name('login');
Route::post('/login', [WeddingAuthController::class, 'login'])->middleware('throttle:6,1')->name('wedding.login.submit');
Route::post('/logout', [WeddingAuthController::class, 'logout'])->middleware('auth')->name('wedding.logout');

Route::get('/invitation-slug-availability', [WeddingBuilderController::class, 'slugAvailability'])
    ->middleware('throttle:30,1')->name('wedding.slugAvailability');
Route::get('/i/{slug}/qr.svg', [WeddingBuilderController::class, 'qrCode'])
    ->middleware('throttle:90,1')->name('wedding.qr');
Route::get('/i/{slug}', [WeddingBuilderController::class, 'show'])->name('wedding.show');
