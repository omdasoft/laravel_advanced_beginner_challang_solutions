<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('users')->group(function() {
        Route::get('/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
        Route::get('/force-delete/{id}', [UserController::class, 'forceDelete'])->name('users.force_delete');
        Route::get('/force-delete-all', [UserController::class, 'forceDeleteAll'])->name('users.force_delete.all');
        Route::get('/restore-all', [UserController::class, 'restoreAll'])->name('users.restore.all');
    });
    Route::prefix('clients')->group(function() {
        Route::get('/restore/{id}', [ClientController::class, 'restore'])->name('clients.restore');
        Route::get('/force-delete/{id}', [ClientController::class, 'forceDelete'])->name('clients.force_delete');
        Route::get('/force-delete-all', [ClientController::class, 'forceDeleteAll'])->name('clients.force_delete.all');
        Route::get('/restore-all', [ClientController::class, 'restoreAll'])->name('clients.restore.all');
    });
    Route::prefix('projects')->group(function() {
        Route::get('/restore/{id}', [ProjectController::class, 'restore'])->name('projects.restore');
        Route::get('/restore-all', [ProjectController::class, 'restoreAll'])->name('projects.restore.all');
        Route::get('/force-delete/{id}', [ProjectController::class, 'forceDelete'])->name('projects.force_delete');
        Route::get('/force-delete-all', [ProjectController::class, 'forceDeleteAll'])->name('projects.force_delete.all');
    });
    Route::prefix('tasks')->group(function() {
        Route::get('/restore/{id}', [TaskController::class, 'restore'])->name('tasks.restore');
        Route::get('/restore-all', [TaskController::class, 'restoreAll'])->name('tasks.restore.all');
        Route::get('/force-delete/{id}', [TaskController::class, 'forceDelete'])->name('tasks.force_delete');
        Route::get('/force-delete-all', [TaskController::class, 'forceDeleteAll'])->name('tasks.force_delete.all');
    });
    Route::resource('projects', ProjectController::class);
    Route::resource('users', UserController::class); 
    Route::resource('clients', ClientController::class);
    Route::resource('tasks', TaskController::class);
});

Auth::routes();


