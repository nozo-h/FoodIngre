<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUsersSettingController;
use App\Http\Controllers\Admin\AdminSelfSettingController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminCategoryController;
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
Route::get('/', function () {
    return view('admin.index');
})->middleware(['auth:admin', 'verified'])->name('index');

Route::middleware('auth:admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 管理者項目のルート
Route::middleware('auth:admin')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // ユーザー設定
    Route::get('/users', [AdminUsersSettingController::class, 'index'])->name('users.index');
    Route::get('/users/edit/{id}', [AdminUsersSettingController::class, 'edit'])->name('users.edit');
    Route::put('/users/update/{id}', [AdminUsersSettingController::class, 'update'])->name('users.update');
    Route::delete('/users/destroy/{id}', [AdminUsersSettingController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/post/{id}', [AdminUsersSettingController::class, 'postIndex'])->name('users.post.index');
    Route::delete('/users/post-delete/{id}', [AdminUsersSettingController::class, 'postDelete'])->name('users.post.delete');
    Route::get('/deleted-users', [AdminUsersSettingController::class, 'deletedUserList'])->name('deleted.users.list');
    Route::patch('/deleted-users/reactivation/{id}', [AdminUsersSettingController::class, 'deletedUserReactivation'])->name('deleted.users.reactivation');
    Route::delete('/deleted-users/delete-completely/{id}', [AdminUsersSettingController::class, 'deletedUserCompletelyDelete'])->name('deleted.users.delete-completely');

    // 管理者設定
    Route::get('/setting',[AdminSelfSettingController::class, 'index'])->name('adminProfile.index');
    Route::put('/setting/update/{id}',[AdminSelfSettingController::class, 'update'])->name('adminProfile.update');
    Route::get('/setting/deleteConfirmation',[AdminSelfSettingController::class, 'deleteConfirmation'])->name('adminProfile.deleteConfirmation');
    Route::delete('setting/deleteExecute/{id}',[AdminSelfSettingController::class, 'delete'])->name('adminProfile.delete');

    // 管理者ユーザー管理
    Route::get('/admins',[AdminSettingController::class, 'index'])->name('admins.index');
    Route::get('/admins/create',[AdminSettingController::class, 'create'])->name('admins.create');
    Route::post('/admins/store',[AdminSettingController::class, 'store'])->name('admins.store');
    Route::get('/admins/edit/{id}',[AdminSettingController::class, 'edit'])->name('admins.edit');
    Route::put('/admins/update/{id}',[AdminSettingController::class, 'update'])->name('admins.update');
    Route::delete('/admin/destroy/{id}',[AdminSettingController::class, 'destroy'])->name('admins.destroy');
    Route::get('/admins/deleted-admins',[AdminSettingController::class, 'deletedAdminList'])->name('deleted.admins.list');
    Route::patch('/admins/deleted-admins/reactivation/{id}',[AdminSettingController::class, 'deletedAdminReactivation'])->name('deleted.admins.reactivation');
    Route::delete('/admins/deleted-admins/deleted-completely/{id}',[AdminSettingController::class, 'deletedAdminCompletely'])->name('deleted.admins.delete-completely');

    // カテゴリ設定
    Route::get('/categories',[AdminCategoryController::class, 'index'])->name('category.index');
    Route::get('/categories/create',[AdminCategoryController::class, 'create'])->name('category.create');
    Route::post('/categories/store',[AdminCategoryController::class, 'store'])->name('category.store');
    Route::get('/categories/edit/{id}', [AdminCategoryController::class, 'edit'])->name('category.edit');
    Route::put('/categories/update/{id}', [AdminCategoryController::class, 'update'])->name('category.update');
    Route::get('/categories/select-delete-items/{id}', [AdminCategoryController::class, 'selectDeleteItems'])->name('category.select-delete-items');
    Route::delete('/categories/delete/{id}', [AdminCategoryController::class, 'delete'])->name('category.delete');

});

Route::middleware('guest')->group(function () {
    // Route::get('register', [RegisteredUserController::class, 'create'])
    //             ->name('register');

    // Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    //             ->name('password.request');

    // Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    //             ->name('password.email');

    // Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    //             ->name('password.reset');

    // Route::post('reset-password', [NewPasswordController::class, 'store'])
    //             ->name('password.store');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
