<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
  ->name('dashboard');

// Authenticated pages (user and admin)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/topics', [PageController::class, 'topics'])->name('topics');
    Route::get('/groups', [PageController::class, 'groups'])->name('groups');
    Route::get('/about', [PageController::class, 'about'])->name('about');

    // News listing accessible to all authenticated users
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
});

// Admin-only pages
Route::middleware(['auth', 'admin'])->group(function () {
    // News management
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::patch('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

    // Example admin dashboard route
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Profile routes (accessible to all authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes
require __DIR__.'/auth.php';
