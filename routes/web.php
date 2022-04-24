<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{IndexController, AdminController, PostController, CategoryController,
    MediaController, OAuthController, TagController, RoleController, PermissionController, RPManagement,
    NewsletterController};
use App\Http\Controllers\Admin\{AdminSearchController};

Route::get('/test', function() {
    // HTML String
    $htmlElement = "<html><body><h1>Hello darkness my old friend</h1><p>This is Sample Text Message 2</p><p>This is Sample Text Message 3</p></body></html>";

    // DOM Parser Object
    $htmlDom = new DOMDocument();
    $htmlDom->loadHTML($htmlElement);

    $title = $htmlDom->getElementsByTagName('h2')[0];
    dd($title);
});

// Roles management
Route::post('/admin/roles', [RoleController::class, 'store']);
Route::patch('/admin/roles', [RoleController::class, 'update']);
Route::delete('/admin/roles', [RoleController::class, 'delete']);
Route::post('/admin/roles/attach-permissions', [RoleController::class, 'attach_permissions']);
Route::post('/admin/roles/detach-permissions', [RoleController::class, 'detach_permissions']);
Route::post('/admin/roles/grant-to-users', [RoleController::class, 'grant']);
Route::post('/admin/roles/revoke-from-users', [RoleController::class, 'revoke']);
Route::patch('/admin/roles/priorities', [RoleController::class, 'update_priorities']);
// Permissions managemet
Route::post('/admin/permissions', [PermissionController::class, 'store']);
Route::patch('/admin/permissions', [PermissionController::class, 'update']);
Route::delete('/admin/permissions', [PermissionController::class, 'delete']);
Route::post('/admin/users/attach-permissions', [PermissionController::class, 'attach_permissions_to_users']);
Route::post('/admin/users/detach-permissions', [PermissionController::class, 'detach_permissions_from_users']);
// Roles & Permissions
Route::get('/admin/roles-and-permissions/overview', [RPManagement::class, 'overview'])->name('admin.rp.overview');
Route::get('/admin/roles-and-permissions/roles', [RPManagement::class, 'manage_roles'])->name('admin.rp.manage.roles');
Route::get('/admin/roles-and-permissions/permissions', [RPManagement::class, 'manage_permissions'])->name('admin.rp.manage.permissions');
Route::get('/admin/roles-and-permissions/users', [RPManagement::class, 'manage_users'])->name('admin.rp.manage.users');
Route::get('/admin/roles/users/search', [RPManagement::class, 'role_users_search']);
Route::get('/admin/permissions/users/search', [RPManagement::class, 'permission_users_search']);
Route::get('/admin/roles/users/search/fetchmore', [RPManagement::class, 'fetch_more_role_users_search']);
Route::get('/admin/permissions/users/search/fetchmore', [RPManagement::class, 'fetch_more_permission_users_search']);
Route::get('/admin/roles/viewers/revoke-viewer', [RPManagement::class, 'get_role_revoke_viewer']);
Route::get('/admin/roles/viewers/grant-viewer', [RPManagement::class, 'get_role_grant_viewer']);
// Comments
Route::get('/admin/comments', [])->name('admin.comments.management');

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

Route::get('/admin/users/search', [AdminSearchController::class, 'users_search']);
Route::get('/admin/users/search/fetchmore', [AdminSearchController::class, 'users_search_fetchmore']);

Route::get('/admin/tags', [TagController::class, 'manage'])->name('admin.tags.management');
Route::post('/admin/tags', [TagController::class, 'store']);
Route::get('/admin/tags/data', [TagController::class, 'data']);
Route::patch('/admin/tags', [TagController::class, 'update']);
Route::delete('/admin/tags', [TagController::class, 'delete']);

Route::get('/login/{provider}', [OAuthController::class, 'redirectToProvider']);
Route::get('/{provider}/callback', [OAuthController::class, 'handleProviderCallback']);

Route::middleware('client.scopes')->group(function() {
    Route::get('/', [IndexController::class, 'index'])->name('root.slash');
    Route::get('/home', [IndexController::class, 'index'])->name('home');
    Route::get('/discover', [IndexController::class, 'discover'])->name('discover');

    Route::get('/posts/fetch', [PostController::class, 'fetch']);

    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe']);

    Route::get('/{category:slug}/{post:slug}/v', [PostController::class, 'view'])->name('view.post');
});
