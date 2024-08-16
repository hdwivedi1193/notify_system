<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes
Route::get('/', [AuthController::class,"showLoginForm"])->name('login');
Route::post('/', [AuthController::class,"login"]);
Route::post('logout', [AuthController::class,"logout"])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::group(['prefix'=> 'admin'], function () {
        
    Route::get('home', [AdminController::class, 'index'])->name('admin.index');
    Route::get('impersonate/{user}', [AdminController::class, 'impersonate'])->name('admin.impersonate');    // Route to impersonate user
    Route::get('stop-impersonate', [AdminController::class, 'stopImpersonate'])->name('admin.stopImpersonate');
    Route::get('notifications', [NotificationController::class, 'create'])->name('admin.notifications.create');
    Route::post("notifications",[NotificationController::class,'store'])->name('admin.notifications.store');
    });

    Route::get('settings/{user}', [SettingController::class, 'edit'])->name('settings.edit');    // Route to edit the settings
    Route::put('settings/{user}', [SettingController::class, 'update'])->name('settings.update');    // Route to update the settings

    
});
