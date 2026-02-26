<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
    Route::post('/posts/{post}/toggle-status', [AdminController::class, 'toggleStatus'])->name('posts.toggle_status');
    Route::get('/comments', [AdminController::class, 'comments'])->name('comments');

    // Super Admin Routes
    Route::middleware(['is_super_admin'])->group(function () {
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update_role');
    });
});
