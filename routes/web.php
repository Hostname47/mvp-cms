<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{IndexController, AdminController, PostController, CategoryController};

Route::get('/test', function() {
    dd(route('create.new.post', ['test1', 'test2']));
});

Route::get('/', [IndexController::class, 'index']);
Route::get('/home', [IndexController::class, 'index']);

Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('create.new.category');
Route::get('/admin/categories/hierarchy/select-one-category-viewer', [CategoryController::class, 'get_select_one_category_viewer']);
Route::get('/admin/categories/hierarchy/subcategories/one-level-subcategories', [CategoryController::class, 'get_one_level_hierarchy_subcategories']);
Route::post('/admin/categories', [CategoryController::class, 'store']);
Route::patch('/categories/priorities', [CategoryController::class, 'update_categories_priorities']);
Route::patch('/admin/category', [CategoryController::class, 'update']);

Route::get('/admin/categories/manage', [CategoryController::class, 'manage'])->name('category.manage');

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/posts/create', [PostController::class, 'create'])->name('create.new.post');
Route::post('/admin/posts', [PostController::class, 'store']);
Route::patch('/admin/posts', [PostController::class, 'update']);
