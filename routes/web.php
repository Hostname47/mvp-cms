<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{IndexController, AdminController, PostController, CategoryController};

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

Route::get('/', [IndexController::class, 'index']);
Route::get('/home', [IndexController::class, 'index']);

Route::prefix('admin')->group(function () {
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('create.new.category');
    Route::post('/categories', [CategoryController::class, 'store']);

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');;
    Route::get('/posts/create', [PostController::class, 'create'])->name('create.new.post');
    Route::post('/posts', [PostController::class, 'store']);
    Route::patch('/posts', [PostController::class, 'update']);
});


