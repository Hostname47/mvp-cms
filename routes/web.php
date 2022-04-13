<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{IndexController, AdminController, PostController, CategoryController,
    MediaController, OAuthController, TagController, RoleController, PermissionController};
use App\Http\Controllers\Admin\{AdminSearchController};

Route::get('/test', function() {
    $posts = \App\Models\Post::withoutGlobalScopes()->get();

    return 'hello';
});

Route::post('/admin/roles', [RoleController::class, 'store']);
Route::patch('/admin/roles', [RoleController::class, 'update']);
Route::delete('/admin/roles', [RoleController::class, 'delete']);
Route::post('/admin/roles/attach-permissions', [RoleController::class, 'attach_permissions']);
Route::post('/admin/roles/detach-permissions', [RoleController::class, 'detach_permissions']);

Route::post('/admin/permissions', [PermissionController::class, 'store']);
Route::patch('/admin/permissions', [PermissionController::class, 'update']);
Route::delete('/admin/permissions', [PermissionController::class, 'delete']);

Route::get('/admin/categories', [CategoryController::class, 'manage'])->name('admin.categories.management');
Route::get('/admin/categories/hierarchy/select-one-category-viewer', [CategoryController::class, 'get_select_one_category_viewer']);
Route::get('/admin/categories/hierarchy/subcategories/one-level-subcategories', [CategoryController::class, 'get_one_level_hierarchy_subcategories']);
Route::post('/admin/categories', [CategoryController::class, 'store']);
Route::patch('/admin/category', [CategoryController::class, 'update']);
Route::patch('/categories/priorities', [CategoryController::class, 'update_categories_priorities']);
Route::patch('/admin/category/status', [CategoryController::class, 'update_status']);
Route::patch('/admin/category/set-as-root', [CategoryController::class, 'set_as_root']);
Route::get('/admin/categories/manage', [CategoryController::class, 'manage'])->name('category.manage');
Route::delete('/admin/categories', [CategoryController::class, 'delete']);

Route::get('/admin/media/fetch', [MediaController::class, 'fetch_media']);
Route::get('/admin/media/set/components', [MediaController::class, 'fetch_media_set_components']);
Route::post('/admin/media-library/upload', [MediaController::class, 'upload']);
Route::patch('/admin/media/metadata', [MediaController::class, 'update_file_metadata']);
Route::delete('/admin/media', [MediaController::class, 'delete_media']);

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/posts', [PostController::class, 'all'])->name('admin.all.posts');
Route::get('/admin/posts/create', [PostController::class, 'create'])->name('create.new.post');
Route::post('/admin/posts', [PostController::class, 'store']);
Route::get('/admin/posts/edit', [PostController::class, 'edit'])->name('edit.post');
Route::patch('/admin/posts', [PostController::class, 'update']);
Route::get('/admin/posts/search', [AdminSearchController::class, 'posts_search']);
Route::get('/admin/posts/data', [PostController::class, 'post_data']); // Used to restore post default content and data in edit page
Route::get('/admin/posts/preview', [PostController::class, 'preview'])->name('preview.post');
Route::patch('/admin/posts/status', [PostController::class, 'update_status']);
Route::post('/admin/posts/trash', [PostController::class, 'delete']);
Route::post('/admin/posts/untrash', [PostController::class, 'restore']);
Route::delete('/admin/posts', [PostController::class, 'destroy']);

Route::get('/admin/tags', [TagController::class, 'manage'])->name('admin.tags.management');
Route::post('/admin/tags', [TagController::class, 'store']);
Route::get('/admin/tags/data', [TagController::class, 'data']);
Route::patch('/admin/tags', [TagController::class, 'update']);
Route::delete('/admin/tags', [TagController::class, 'delete']);

Route::middleware('client.scopes')->group(function() {
    Route::get('/{category:slug}/{post:slug}', [PostController::class, 'view'])->name('view.post');
    Route::get('/', [IndexController::class, 'index']);
    Route::get('/home', [IndexController::class, 'index'])->name('home');
});

Route::get('/login/{provider}', [OAuthController::class, 'redirectToProvider']);
Route::get('/{provider}/callback', [OAuthController::class, 'handleProviderCallback']);
