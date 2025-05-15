<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'telegram_verified'])->group(function () {
    Route::redirect('/', '/dashboard')->name('home');
    Route::get('/dashboard', [NewsController::class, 'index'])->name('dashboard');
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/search', [NewsController::class, 'search'])->name('news.search');
    Route::get('/news/{article}', [NewsController::class, 'show'])->name('news.show');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::post('news/update-all-sources', [NewsController::class, 'updateAllSources'])->name('news.update-all-sources');
});
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
