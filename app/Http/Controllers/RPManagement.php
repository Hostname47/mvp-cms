<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

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

    public function manage_roles(Request $request) {
        $role = null;
        $roles = Role::orderBy('priority', 'asc')->get();
        $users = collect([]);
        $scoped_permissions = collect([]);
        if($request->has('role')) {
            $role_slug = $request->validate(['role'=>'exists:roles,slug'])['role'];
            $role = Role::where('slug', $role_slug)->first();
            $users = $role->users;
            $scoped_permissions = $role->permissions->groupBy('scope');
        }

        return view('admin.roles-and-permissions.manage-roles')
            ->with(compact('roles'))
            ->with(compact('role'))
            ->with(compact('users'))
            ->with(compact('scoped_permissions'));
    }
}
