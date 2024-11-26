<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserTaskController;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'goLogin'])->name('login.index');
Route::post('login', [AuthController::class, 'login'])->name('login.page');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['check:user'])->group(function () {
    Route::get('/main', [MainController::class, 'index'])->name('main.page');
    Route::get('/myTask', [UserTaskController::class, 'index'])->name('myTask.page');
    Route::post('task-open/{regionTask}', [UserTaskController::class, 'taskOpen'])->name('tasks.open');
    Route::post('tasks-do{regionTask}', [UserTaskController::class, 'response'])->name('tasks.do');
    Route::get('/profile', [AuthController::class, 'userEdit'])->name('profile.edit');
    Route::put('/profile/{user}', [AuthController::class, 'userUpdate'])->name('profile.update');
});

Route::middleware(['check:admin'])->group(function () {
    Route::get('/', [MainController::class, 'admin'])->name('admin.index');
    Route::get('/users', [AuthController::class, 'index'])->name('users.page');
    Route::post('/users', [AuthController::class, 'store'])->name('user.store');
    Route::delete('/users/{user}', [AuthController::class, 'destroy'])->name('user.delete');
    Route::put('/users/{user}', [AuthController::class, 'update'])->name('user.update');

    Route::get('/category', [CategoryController::class, 'index'])->name('category.page');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.delete');
    Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');

    Route::get('/region', [RegionController::class, 'index'])->name('region.page');
    Route::post('/region', [RegionController::class, 'store'])->name('region.store');
    Route::delete('/region/{region}', [RegionController::class, 'destroy'])->name('region.delete');
    Route::put('/region/{region}', [RegionController::class, 'update'])->name('region.update');

    Route::get('/task', [TaskController::class, 'index'])->name('task.page');
    Route::post('/task', [TaskController::class, 'store'])->name('task.store');
    Route::delete('/task/{task}', [TaskController::class, 'destroy'])->name('task.delete');
    Route::put('/task/{regionTask}', [TaskController::class, 'update'])->name('task.update');

    Route::get('/response', [ResponseController::class, 'index'])->name('response.page');
    Route::put('/response/{response}', [ResponseController::class, 'checkResponse'])->name('response.check');

    Route::get('/report', [MainController::class, 'report'])->name('report.page');
    Route::get('/control', [MainController::class, 'control'])->name('control.page');
    Route::get('/mainreport', [MainController::class, 'mainReport'])->name('mainReport.page');
});
