<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{IndexController, AdminController, PostController, CategoryController};

Route::get('/test', function() {
    dd(\App\Models\Category::find(8)->descendants()->count());
});

Route::get('/', [IndexController::class, 'index']);
Route::get('/home', [IndexController::class, 'index']);

Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('create.new.category');
Route::get('/admin/categories/hierarchy/select-one-category-viewer', [CategoryController::class, 'get_select_one_category_viewer']);
Route::get('/admin/categories/hierarchy/subcategories/one-level-subcategories', [CategoryController::class, 'get_one_level_hierarchy_subcategories']);
Route::post('/admin/categories', [CategoryController::class, 'store']);
Route::patch('/categories/priorities', [CategoryController::class, 'update_categories_priorities']);
Route::patch('/admin/category', [CategoryController::class, 'update']);
Route::patch('/admin/category/status', [CategoryController::class, 'update_status']);
Route::patch('/admin/category/set-as-root', [CategoryController::class, 'set_as_root']);

Route::get('/admin/categories/manage', [CategoryController::class, 'manage'])->name('category.manage');

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/posts/create', [PostController::class, 'create'])->name('create.new.post');
Route::post('/admin/posts', [PostController::class, 'store']);
Route::patch('/admin/posts', [PostController::class, 'update']);
