<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Role,User,Permission,PermissionRole};
use App\View\Components\Admin\Role\RevokeViewer;

class RPManagement extends Controller
{
    public function overview() {
        $roles = Role::orderBy('priority', 'asc')->get();
        $roleusers = collect([]);

        foreach($roles as $role) {
            /**
             * For each role (slug) we need to have a collection of users who own that role
             */
            $roleusers[$role->slug] = [];
            
            foreach($role->users as $user) {
                /**
                 * Here, If a user is admin and author at the same times, we only need to insert
                 * him in (high priority role) admins collection; to avoid repitition
                 */
                if(!$roleusers->flatten()->firstWhere('id', $user->id)) {
                    $users = $roleusers->get($role->slug);
                    $users[] = $user;
                    $roleusers->put($role->slug, $users);
                }
            }
        }

        return view('admin.roles-and-permissions.overview')
            ->with(compact('roles'))
            ->with(compact('roleusers'));
    }

    /**
     * --- Roles management ---
     */
    public function manage_roles(Request $request) {
        $role = null;
        $roles = Role::orderBy('priority', 'asc')->get();
        $users = collect([]);
        $all_permissions_scoped = collect([]);
        $scoped_permissions = collect([]);
        if($request->has('role')) {
            $role_slug = $request->validate(['role'=>'exists:roles,slug'])['role'];
            $role = Role::where('slug', $role_slug)->first();
            $users = $role->users;
            $scoped_permissions = $role->permissions->groupBy('scope');
            // In the following, we eager load roles, to prevent querying permission roles relationship
            // on each permission because we'll check if the permission already attached to role or not (avoid N+1 issue)
            $all_permissions_scoped = Permission::with('roles')->get()->groupBy('scope');
        }

        return view('admin.roles-and-permissions.manage-roles')
            ->with(compact('roles'))
            ->with(compact('role'))
            ->with(compact('users'))
            ->with(compact('scoped_permissions'))
            ->with(compact('all_permissions_scoped'));
    }
    public function role_users_search(Request $request ) {
        $data = $request->validate([
            'role'=>'required|exists:roles,id',
            'k'=>'required|min:1|max:255'
        ]);

        $role = Role::find($data['role']);
        $users = User::withoutGlobalScopes()->where('username', 'like', "%" . $data['k'] . "%")->take(9)->get();
        $hasmore = $users->count() > 8;
        $users = $users->take(8)->map(function($user) use ($role) {
            return [
                'id'=>$user->id,
                'fullname'=>$user->fullname,
                'username'=>$user->username,
                'avatar'=>$user->avatar(100),
                'role'=>($high_role = $user->high_role()) ? $high_role->title : null,
                'user_manage_link'=>'',
                'already_has_this_role'=>$user->has_role($role->slug)
            ];
        });

        return [
            'users'=>$users,
            'hasmore'=>$hasmore
        ];
    }
    public function fetch_more_role_users_search(Request $request) {
        $data = $request->validate([
            'role'=>'required|exists:roles,id',
            'skip'=>'required|numeric',
            'k'=>'required|min:1|max:255'
        ]);

        $role = Role::find($data['role']);
        $users = User::withoutGlobalScopes()->where('username', 'like', "%" . $data['k'] . "%")->skip($data['skip'])->take(9)->get();
        $hasmore = $users->count() > 8;
        $users = $users->take(8)->map(function($user) use ($role) {
            return [
                'id'=>$user->id,
                'fullname'=>$user->fullname,
                'username'=>$user->username,
                'avatar'=>$user->avatar(100),
                'role'=>($high_role = $user->high_role()) ? $high_role->title : null,
                'user_manage_link'=>'',
                'already_has_this_role'=>$user->has_role($role->slug)
            ];
        });

        return [
            'users'=>$users,
            'hasmore'=>$hasmore
        ];
    }
    public function get_role_revoke_viewer(Request $request) {
        $data = $request->validate([
            'role'=>'required|exists:roles,id',
            'user'=>'required|exists:users,id'
        ]);
        $role = Role::find($data['role']);
        $user = User::withoutGlobalScopes()->find($data['user']);
        
        $reviewviewer = (new RevokeViewer($role, $user));
        $reviewviewer = $reviewviewer->render(get_object_vars($reviewviewer))->render();
        return $reviewviewer;
    }

    /** 
     * --- Permissions management ---
     */
    public function manage_permissions(Request $request) {
        $permission = null;
        $prole = null;
        $roles = collect([]);
        $root_permissions = collect([]);
        $scoped_permissions = collect([]);
        $scopes = collect([]);

        if($request->has('permission')) {
            $permission_slug = $request->validate(['permission'=>'exists:permissions,slug'])['permission'];
            $permission = Permission::where('slug', $permission_slug)->first();
            $scopes = Permission::select('scope')->distinct()->pluck('scope');
            $prole = $permission->role();
        } else {
            $roles = Role::orderBy('priority', 'asc')->get();
            $root_permissions = Permission::whereNotIn('id', PermissionRole::pluck('permission_id')->toArray())->get();
            $scoped_permissions = Permission::orderBy('scope')->get()->groupBy('scope');
            $scopes = $scoped_permissions->keys();
        }
        return view('admin.roles-and-permissions.manage-permissions')
            ->with(compact('permission'))
            ->with(compact('root_permissions'))
            ->with(compact('scoped_permissions'))
            ->with(compact('scopes'))
            ->with(compact('prole'))
            ->with(compact('roles'));
    }
    public function permission_users_search(Request $request) {
        $data = $request->validate([
            'permission'=>'required|exists:permissions,id',
            'k'=>'required|min:1|max:255'
        ]);

        $permission = Permission::find($data['permission']);
        $users = User::withoutGlobalScopes()->where('username', 'like', "%" . $data['k'] . "%")->take(9)->get();
        $hasmore = $users->count() > 8;
        $users = $users->take(8)->map(function($user) use ($permission) {
            return [
                'id'=>$user->id,
                'fullname'=>$user->fullname,
                'username'=>$user->username,
                'avatar'=>$user->avatar(100),
                'role'=>($high_role = $user->high_role()) ? $high_role->title : null,
                'user_manage_link'=>'',
                'already_has_this_permission'=>$user->has_permission($permission->slug)
            ];
        });

        return [
            'users'=>$users,
            'hasmore'=>$hasmore
        ];
    }
    public function fetch_more_permission_users_search(Request $request) {
        $data = $request->validate([
            'permission'=>'required|exists:permissions,id',
            'skip'=>'required|numeric',
            'k'=>'required|min:1|max:255'
        ]);

        $permission = Permission::find($data['permission']);
        $users = User::withoutGlobalScopes()->where('username', 'like', "%" . $data['k'] . "%")->skip($data['skip'])->take(9)->get();
        $hasmore = $users->count() > 8;
        $users = $users->take(8)->map(function($user) use ($permission) {
            return [
                'id'=>$user->id,
                'fullname'=>$user->fullname,
                'username'=>$user->username,
                'avatar'=>$user->avatar(100),
                'role'=>($high_role = $user->high_role()) ? $high_role->title : null,
                'user_manage_link'=>'',
                'already_has_this_permission'=>$user->has_permission($permission->slug)
            ];
        });

        return [
            'users'=>$users,
            'hasmore'=>$hasmore
        ];
    }

    /**
     * --- User roles and permissions management
     */
    public function manage_users(Request $request) {
        $user = null;
        if($request->has('user')) {
            $user = User::withoutGlobalScopes()->where('username', $request->get('user'))->first();
        }

        return view('admin.roles-and-permissions.manage-users-roles-and-permissions')
            ->with(compact('user'));
    }
}
