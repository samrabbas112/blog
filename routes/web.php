<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\Admin\LoginController as AdminLoginController;
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

Auth::routes(['verify' => true]); // Disable registration if not needed
Route::group(['middleware' =>'auth'],function() {

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers.list');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
});

// Admin authentication routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login'); // Admin login form
    Route::post('login', [AdminLoginController::class, 'login'])->name('login.post');   // Admin login submit
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');     // Admin logout
});

// Admin protected routes (requires auth:admin middleware)
Route::group(['middleware' =>'admin'],function() {
    Route::get('/admin/dashboard', [HomeController::class, 'dashboard'])->name('dashboard'); // Admin dashboard

    // Category routes
    Route::post('/category/store', [AdminCategoryController::class, 'store'])->name('category.store');
    Route::get('/category/index', [AdminCategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create/{id?}', [AdminCategoryController::class, 'create'])->name('category.create');
    Route::delete('/category/destroy/{id}', [AdminCategoryController::class, 'destroy'])->name('category.destroy');

    // Tag routes
    Route::post('/tags/store', [AdminTagController::class, 'store'])->name('tags.store');
    Route::delete('/tags/destroy/{id}', [AdminTagController::class, 'destroy'])->name('tags.destroy');
    Route::get('/tags/index', [AdminTagController::class, 'index'])->name('tags.index');
    Route::get('/tags/create/{id?}', [AdminTagController::class, 'create'])->name('tags.create');

    // Post routes
    Route::post('/posts/store', [AdminPostController::class, 'store'])->name('posts.store');
    Route::get('/posts/index', [AdminPostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create/{id?}', [AdminPostController::class, 'create'])->name('posts.create');
    Route::delete('/posts/destroy/{id}', [AdminPostController::class, 'destroy'])->name('posts.destroy');

    // User routes
    Route::post('/users/store', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/index', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create/{id?}', [AdminUserController::class, 'create'])->name('users.create');
    Route::delete('/users/destroy/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});
