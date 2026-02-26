<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/search', [PostController::class, 'search'])->name('posts.search');

// Auth Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Post Routes
Route::resource('posts', PostController::class)->except(['index', 'show']);
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Comments Route (Nested under post)
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Require admin routes
require __DIR__ . '/admin.php';
