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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::controller(\App\Http\Controllers\Auth\Api\loginController::class)->group(function () {
    Route::post('login', [\App\Http\Controllers\Auth\Api\loginController::class, 'login'])->name('login.post');
});
// API Versioning with Sanctum Authentication
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/category', \App\Http\Controllers\Admin\Api\CategoryController::class)
        ->names([
            'index' => 'api.v1.category.index',
            'store' => 'api.v1.category.store',
            'update' => 'api.v1.category.update',
            'destroy' => 'api.v1.category.destroy',
        ]);

    Route::apiResource('/posts', \App\Http\Controllers\Admin\Api\PostController::class)
        ->names([
            'index' => 'api.v1.posts.index',
            'store' => 'api.v1.posts.store',
            'update' => 'api.v1.posts.update',
            'destroy' => 'api.v1.posts.destroy',
        ]);

    Route::apiResource('/tags', \App\Http\Controllers\Admin\Api\TagsController::class)
        ->names([
            'index' => 'api.v1.tags.index',
            'store' => 'api.v1.tags.store',
            'update' => 'api.v1.tags.update',
            'destroy' => 'api.v1.tags.destroy',
        ]);
});



