<?php
use App\Models\Task;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    $tasks = Task::all();
    return view('welcome', compact('tasks'));
});

Route::resource('tasks', TaskController::class);
