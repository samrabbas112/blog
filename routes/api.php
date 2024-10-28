<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/category/store', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('category.store');
Route::get('/category/index', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create/{id?}', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('category.create');
Route::delete('/category/destroy/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('category.destroy');
