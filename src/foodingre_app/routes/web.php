<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PostController;

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


// ホーム
Route::get('/', [SearchController::class, 'index'])->name('index');

// ユーザー（プロフィール情報設定)
Route::middleware('auth:users')->group(function () {
    Route::get('/user/setting',[UserController::class, 'edit'])->name('userProfile.edit');
    Route::put('/user/setting/update/{id}', [UserController::class, 'update'])->name('userProfile.update');
    Route::get('/user/setting/deleteConfirmation', [UserController::class, 'deleteConfirmation'])->name('userProfile.deleteConfirmation');
    Route::delete('/user/setting/deleteExecute/{id}', [UserController::class, 'delete'])->name('userProfile.delete');
});

// ユーザーページの表示
Route::get('/user/{id}',[UserController::class, 'index'])->name('userProfile.index');
// Route::middleware('auth:users')->get('/user/{id}/privatePosts', [UserController::class, 'privatePosts'])->name('userProfile.privatePosts');

// 投稿
Route::middleware('auth:users')->group(function () {
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/create/store',[PostController::class, 'store'])->name('post.create.store');
    Route::get('/post/{id}/edit',[PostController::class, 'edit'])->name('post.edit');
    Route::put('/post/{id}/update', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/{id}/destroy', [PostController::class, 'destroy'])->name('post.destroy');
});

// 投稿の表示（公開のみ）
Route::get('/post/{id}', [SearchController::class, 'show'])->name('post.show');

// 検索
Route::get('/search',[SearchController::class, 'search'])->name('search');
Route::get('/category/{id}',[SearchController::class, 'searchFromCategory'])->name('search.category');
Route::get('/category',[SearchController::class, 'category'])->name('category');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
