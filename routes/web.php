<?php

use App\Http\Controllers\ProfileController;
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
});




//==========test==========
use App\Models\User;
use App\Models\Task;

Route::get('/testmain', function () {

    $tasks = Task::paginate(2);
    $totalCount = count(Task::all());
    $newCount=1;
$inProgressCount=2;
$completedCount=3;

    return view('proj2.pageMain',compact('tasks','totalCount','newCount','inProgressCount','completedCount'));
    //return view('proj2.testbootstrap');

});

Route::get('/testmain2', function () {

    return view('proj2.projectList');

});

Route::get('/testmain3', function () {

    return view('proj2.dashboard');

});

Route::get('/testmain4', function () {

   $users=User::all();
   return view('proj2.admindashboard',compact('users'));

});

//===========================

require __DIR__.'/auth.php';
