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
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\AdminMiddleware;

// Sakne → publiskā sākumlapa
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Maršruti, kuriem nepieciešama autentifikācija
Route::middleware(['auth'])->group(function () {

    // Vadības panelis
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    // Tēmas
    Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');
    Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
    Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');

    // Pārvaldība (administratoram paredzēts pārbaudes slānis kontrolierī)
    Route::get('/topics/{topic}/edit', [TopicController::class, 'edit'])->name('topics.edit');
    Route::patch('/topics/{topic}', [TopicController::class, 'update'])->name('topics.update');
    Route::delete('/topics/{topic}', [TopicController::class, 'destroy'])->name('topics.destroy');

    // Skats (jāpaliek pēc labošanas maršruta)
    Route::get('/topics/{topic}', [TopicController::class, 'show'])->name('topics.show');

    // Grupas
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');
    // Atjaunots atpakaļ
    Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::patch('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');

    Route::post('/groups/{group}/join', [GroupController::class, 'join'])->name('groups.join');
    Route::post('/groups/{group}/leave', [GroupController::class, 'leave'])->name('groups.leave');
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');

    // Ieraksti
    Route::get('/groups/{group}/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/groups/{group}/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Patīk un komentāri
    Route::post('/posts/{post}/like', [PostLikeController::class, 'toggle'])->name('posts.like');
    Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('posts.comment');
    Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('posts.comments');

    // Ziņojumi
    Route::post('/posts/{post}/report', [ReportController::class, 'store'])->name('reports.store');

    // Jaunumi
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');

    // Par sistēmu
    Route::get('/about', [PageController::class, 'about'])->name('about');

    // Profils
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Paziņojumi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Administrācijas panelis (autentificēts + administrators)
    Route::prefix('admin')
        ->middleware([AdminMiddleware::class])
        ->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('admin.index');
            Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
            Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
            Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
            Route::patch('/reports/{report}/resolve', [ReportController::class, 'resolve'])->name('admin.reports.resolve');
        });
});

require __DIR__ . '/auth.php';
