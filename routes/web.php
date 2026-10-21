<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PlatformController;
use App\Http\Controllers\Public\ArticleController;
use App\Http\Controllers\Public\BookController;
use App\Http\Controllers\Public\FreeResourceController;
use App\Http\Controllers\Public\DigitalProductController;

// --- PUBLIC ROUTES ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/platform/{slug}', [PlatformController::class, 'show'])->name('platform.show');
Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('artikel.show');
Route::get('/tutorial', [\App\Http\Controllers\Public\TutorialController::class, 'index'])->name('tutorial.index');
Route::get('/tutorial/{slug}', [\App\Http\Controllers\Public\TutorialController::class, 'show'])->name('tutorial.show');
Route::get('/bacaan-rekomendasi', [BookController::class, 'index'])->name('bacaan.index');
Route::get('/free-resources', [FreeResourceController::class, 'index'])->name('free-resources.index');
Route::get('/digital-product', [DigitalProductController::class, 'index'])->name('digital-product.index');

Route::prefix('hany4dmin')->name('admin.')->group(function () {
    // Auth Routes
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('throttle:10,1');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // 2FA Routes (Requires Authentication only)
    Route::middleware('admin.auth')->group(function () {
        Route::get('/2fa', [AdminAuthController::class, 'show2fa'])->name('2fa');
        Route::post('/2fa', [AdminAuthController::class, 'verify2fa'])->middleware('throttle:10,1');
    });

    // Protected Routes (Requires Authentication and 2FA Verification)
    Route::middleware(['admin.auth', 'admin.2fa'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Content Categories
        Route::resource('categories', \App\Http\Controllers\Admin\ContentCategoryController::class)->except(['show']);
        
        // Platform Categories
        Route::resource('platform-categories', \App\Http\Controllers\Admin\PlatformCategoryController::class)->parameters([
            'platform-categories' => 'platform_category'
        ])->except(['show']);

        // Platforms
        Route::resource('platforms', \App\Http\Controllers\Admin\PlatformController::class)->except(['show']);
        
        // Articles
        Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class)->except(['show']);
        
        // Tutorials
        Route::resource('tutorials', \App\Http\Controllers\Admin\TutorialController::class)->except(['show']);
        
        // Books (Bacaan Rekomendasi)
        Route::resource('books', \App\Http\Controllers\Admin\BookController::class)->except(['show']);
        
        // Free Resources
        Route::resource('free-resources', \App\Http\Controllers\Admin\FreeResourceController::class)->parameters([
            'free-resources' => 'free_resource'
        ])->except(['show']);
        
        // Digital Products
        Route::resource('digital-products', \App\Http\Controllers\Admin\DigitalProductController::class)->parameters([
            'digital-products' => 'digital_product'
        ])->except(['show']);
        
        // Future CRUD routes will be added here
    });
});
