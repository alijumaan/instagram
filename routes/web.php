<?php

use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\LikeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\FollowController;
use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';


Route::group(['middleware' => ['auth']], function() {

    // HOME
    Route::get('/', [PostController::class, 'index'])->name('home');

    // USERS
    Route::resource('users', UserController::class)->only('index', 'update');
    Route::get('/user/profile', [UserController::class, 'edit'])->name('profile');
    Route::get('/user_info/{id}', [UserController::class, 'userInfo'])->name('user.info');
    Route::get('/search', [UserController::class, 'search']);

    // POSTS
    Route::resource('posts', PostController::class);
    Route::get('/user/{id}/posts', [PostController::class, 'userFriendPosts'])->name('user.friend.posts');

    // LIKES
    Route::resource('likes', LikeController::class)->only('store', 'destroy');

    // COMMENTS
    Route::resource('comments', CommentController::class)->only('store', 'destroy');

    // FOLLOW
    Route::resource('followers', FollowController::class);


});
