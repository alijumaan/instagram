<?php

use App\Http\Controllers\Frontend\LikeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\UserController;
use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';

// HOME
Route::get('/', [PostController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    // USERS
    Route::resource('users', UserController::class)->only('update', 'destroy');
    Route::get('/user/profile', [UserController::class, 'edit'])->name('profile');

    // POST
    Route::resource('posts', PostController::class);

    // LIKE
    Route::resource('likes', LikeController::class);
});
