<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CommentsController;

Route::get('/projects/{project}/tasks', [TaskController::class, 'index'])->name('index');
Route::post('/projects/{project}/tasks', [TaskController::class, 'store']);
Route::delete('/projects/{project}/tasks', [TaskController::class, 'destroy']);


Route::get('/projects/{project}/tasks/{task}', [TaskController::class, 'show'])->name('show');
Route::post('/tasks/{task}/comments', [CommentsController::class, 'store'])
    ->name('comments.store')
    ->middleware('auth'); // User should be authorized


// DELETE /comments/{comment}
Route::delete('/comments/{comment}', [CommentsController::class, 'destroy'])
    ->name('comments.destroy')
    ->middleware('auth');


//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/', [ProjectController::class, 'index']);


