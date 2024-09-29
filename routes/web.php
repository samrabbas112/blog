<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::prefix('admin')->name('admin.')->group(function () {
    Auth::routes(['verify' => true, 'register' => false]); // Disable registration for admins if necessary
});



Route::group(['middleware' =>'auth:admin'],function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
    Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers.list');

    //Update User Details
    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

    Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

    //Language Translation
    Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
    // Post routes
    
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/index/', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create/{id?}', [CategoryController::class, 'create'])->name('category.create');
    Route::delete('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    
    
    Route::post('/tags/store', [TagController::class, 'store'])->name('tags.store');
    Route::delete('/tags/destroy/{id}', [TagController::class, 'destroy'])->name('tags.destroy');
    Route::get('/tags/index/', [TagController::class, 'index'])->name('tags.index');
    Route::get('/tags/create/{id?}', [TagController::class, 'create'])->name('tags.create');
    
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/index/', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create/{id?}', [PostController::class, 'create'])->name('posts.create');
    Route::delete('/posts/destroy/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/show/{id}', [PostController::class, 'show'])->name('posts.show');
    
    
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/index/', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create/{id?}', [UserController::class, 'create'])->name('users.create');
    Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    
    
});
