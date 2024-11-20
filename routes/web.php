<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.index');
});

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