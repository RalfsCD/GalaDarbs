<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController; // ✅ Add this

// Root
Route::get('/', [PageController::class, 'dashboard'])->name('home');

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    // Topics
    Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');
    Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
    Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
    Route::get('/topics/{topic}', [TopicController::class, 'show'])->name('topics.show');

    // Groups
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');
    Route::post('/groups/{group}/join', [GroupController::class, 'join'])->name('groups.join');
    Route::post('/groups/{group}/leave', [GroupController::class, 'leave'])->name('groups.leave');

    // Posts
    Route::get('/groups/{group}/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/groups/{group}/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Likes & Comments
    Route::post('/posts/{post}/like', [PostLikeController::class, 'toggle'])->name('posts.like');
    Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('posts.comment');

    // Report posts
    Route::post('/posts/{post}/report', [ReportController::class, 'store'])->name('reports.store');

    // News
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');

    // About
    Route::get('/about', [PageController::class, 'about'])->name('about');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Admin Panel
    Route::prefix('admin')->group(function () {

        // Admin Dashboard: shows unsolved reports
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');

        // Users management
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

        // Reports management
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::patch('/reports/{report}/resolve', [ReportController::class, 'resolve'])->name('admin.reports.resolve');

    });
});

require __DIR__.'/auth.php';
