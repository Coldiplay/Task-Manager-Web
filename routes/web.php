<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/projects/{project}/tasks', [TaskController::class, 'index'])->name('tasks.index');

Route::get('/', function () {
    return view('welcome');
});


