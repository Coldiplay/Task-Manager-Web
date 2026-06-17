<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminInterfaceMiddleware;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CommentsController;

Route::get('/projects/{project}/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks/{task}/comments', [CommentsController::class, 'store'])
    ->name('comments.store')
    ->middleware('auth'); // User should be authorized

// DELETE /comments/{comment}
Route::delete('/comments/{comment}', [CommentsController::class, 'destroy'])
    ->name('comments.destroy')
    ->middleware('auth');


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
