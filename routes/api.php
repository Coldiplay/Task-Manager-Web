 <?php

 use App\Http\Controllers\TaskController;
 use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Swagger Documentation - редирект на Swagger UI
Route::get('/docs', function () {
    return redirect()->to('/spectrum/openapi.html');
});


 Route::post('/projects/{project}/tasks', [TaskController::class, 'store']);

 Route::get('/project/{project}/tasks/{task}',[TaskController::class,'show'])->name('task.show');
 Route::delete('/project/{project}/tasks/{task}',[TaskController::class,'show'], 'destroy');

// Protected routes (требуют авторизации)
Route::middleware('auth:sanctum')->group(function () {

});
