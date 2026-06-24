<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


// User should be authorized
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    Route::group(['prefix' => 'project'], function () {
        Route::get('/', [ProjectController::class, 'index'])
            ->name('project.index');

        Route::post('/', [ProjectController::class, 'store'])
            ->name('project.store');


        Route::group(['prefix' => '{project}'], function () {
            Route::get('/', [ProjectController::class, 'show'])
                ->name('project.show');
            Route::put('/', [ProjectController::class, 'update'])
                ->name('project.update');
            Route::delete('/', [ProjectController::class, 'destroy'])
                ->name('project.destroy');


            Route::group(['prefix' => 'tasks'], function () {
                Route::get('/', [TaskController::class, 'index'])
                    ->name('task.index');
                Route::post('/', [TaskController::class, 'store'])
                    ->name('task.store');


                Route::group(['prefix' => '{task}'], function () {
                    Route::get('/',[TaskController::class,'show'])
                        ->name('task.show');

                    Route::put('/', [TaskController::class, 'update'])
                        ->name('task.update');

                    Route::delete('/',[TaskController::class,'destroy'])
                        ->name('task.destroy');
                });
            });

        });
    });

    Route::group(['prefix' => 'task'], function () {

        Route::group(['prefix' => '{task}'], function () {

            Route::group(['prefix' => 'comments'], function () {
                Route::get('/', [CommentsController::class, 'index'])
                    ->name('comment.index');

                Route::post('/', [CommentsController::class, 'store'])
                    ->name('comment.store');
            });
        });


        Route::prefix('admin')->name('admin.')->middleware('moonshine')->group(function () {
            Route::put('users/{user}/block', [AdminUserController::class, 'toggleBlock'])
                ->name('users.block');
            Route::put('users/{user}/role', [AdminUserController::class, 'changeRole'])
                ->name('users.role');
        });
    });


    // DELETE /comments/{comment}
    Route::delete('/comments/{comment}', [CommentsController::class, 'destroy'])
        ->name('comment.destroy');
});


Route::get('/', function () {
    return view('welcome');
});


require __DIR__.'/auth.php';
