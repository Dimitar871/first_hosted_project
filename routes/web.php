<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create.test');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public: View all tasks & single task
Route::get('/',             [TaskController::class, 'index'])->name('home');
Route::get('/tasks',        [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

// Authenticated-only: create/edit/update/delete
Route::middleware('auth')->group(function () {
    Route::get('/tasks/create',          [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks',                [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit',     [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}',          [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}',       [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Optional dashboard
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Breeze profile
    Route::get('/profile',               [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',             [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',            [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze auth routes (login, register, etc.)
require __DIR__.'/auth.php';
