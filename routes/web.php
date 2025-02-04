<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/home', [HomeController::class, 'home'])->name('home');


Auth::routes(['verify' => true]);

Route::get('/settings', [HomeController::class, 'settings'])->name('settings');
Route::get('/verify', [HomeController::class, 'verification'])->name('verification');

Route::prefix('/settings')->group(function () {
    Route::put('/user/{user}/name', [SettingsController::class, 'updateName'])->name('user.updateName');
    Route::put('/user/{user}/password', [SettingsController::class, 'updatePassword'])->name('user.updatePassword');
});

Route::get('/admin', [AdministradorController::class, 'index'])->name('admin');
Route::resource('/admin/users', UserController::class);

