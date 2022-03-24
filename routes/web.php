<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{IndexController, AdminController, PostController, CategoryController};

Route::get('/', [IndexController::class, 'index']);
Route::get('/home', [IndexController::class, 'index']);

Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('create.new.category');
Route::get('/admin/categories/hierarchy/selection/select-one-category', [CategoryController::class, 'get_select_one_category_hierarchy']);
Route::get('/admin/categories/hierarchy/selection/select-one-category-level', [CategoryController::class, 'get_select_one_category_hierarchy_level']);
Route::post('/admin/categories', [CategoryController::class, 'store']);

Route::get('/admin/categories/management', [CategoryController::class, 'manage'])->name('category.manage');

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/posts/create', [PostController::class, 'create'])->name('create.new.post');
Route::post('/admin/posts', [PostController::class, 'store']);
Route::patch('/admin/posts', [PostController::class, 'update']);
