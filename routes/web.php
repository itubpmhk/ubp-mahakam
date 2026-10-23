<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

/* ---------------- public site ---------------- */
Route::get('/', HomeController::class)->name('home');
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{post:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/portal', PortalController::class)->name('portal');
Route::view('/tentang', 'site.about')->name('about');

/* ---------------- admin login ---------------- */
// Laravel's "auth" middleware sends guests to the route named "login".
Route::get('admin/login', [Admin\AuthController::class, 'showLogin'])->name('login');
Route::post('admin/login', [Admin\AuthController::class, 'login'])->middleware('throttle:20,1')->name('login.attempt');

/* ---------------- admin panel ---------------- */
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');

    Route::get('/', Admin\DashboardController::class)->name('dashboard');

    Route::get('konten', [Admin\SettingController::class, 'edit'])->name('settings.edit');
    Route::put('konten', [Admin\SettingController::class, 'update'])->name('settings.update');

    Route::resource('komitmen', Admin\CommitmentController::class)
        ->parameters(['komitmen' => 'commitment'])->names('commitments')->except('show');

    Route::post('berita/upload-gambar', [Admin\PostController::class, 'uploadInline'])->name('posts.upload');
    Route::resource('berita', Admin\PostController::class)
        ->parameters(['berita' => 'post'])->names('posts')->except('show');

    Route::resource('aplikasi', Admin\PortalAppController::class)
        ->parameters(['aplikasi' => 'app'])->names('apps')->except('show');

    Route::get('akun', [Admin\AccountController::class, 'edit'])->name('account.edit');
    Route::put('akun/profil', [Admin\AccountController::class, 'updateProfile'])->name('account.profile');
    Route::put('akun/password', [Admin\AccountController::class, 'updatePassword'])->name('account.password');
    Route::post('akun/admin', [Admin\AccountController::class, 'storeAdmin'])->name('account.admins.store');
    Route::delete('akun/admin/{user}', [Admin\AccountController::class, 'destroyAdmin'])->name('account.admins.destroy');
});
