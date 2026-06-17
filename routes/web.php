<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminInterfaceMiddleware;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->middleware('moonshine')->group(function () {
        Route::put('users/{user}/block', [AdminUserController::class, 'toggleBlock'])
            ->name('users.block');
        Route::put('users/{user}/role', [AdminUserController::class, 'changeRole'])
            ->name('users.role');
    });
});

require __DIR__.'/auth.php';
