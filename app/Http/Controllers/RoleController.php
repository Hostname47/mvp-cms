<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\{User,Role};

class RoleController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'title'=>'required|max:255|unique:roles,title',
            'slug'=>'required|max:255|unique:roles,slug',
            'description'=>'required|max:2000'
        ]);

        /**
         * First we have to get max priority value and add 1, to attach to the created role the lowest priority value
         * Remember the highest priority column is, the lowest priveleges you will have (e.g. priority=1 is for super admin with no restrictions)
         */
        $lowest_priority = \DB::select("SELECT MAX(priority) as maxpriority FROM roles")[0]->maxpriority;
        $data['priority'] = ++$lowest_priority;
        $role = Role::create($data);

        Session::flash('message', 'Role "' . $role->title . '" has been created successfully. Now you can attach permissions to that role and then grant it to users');
        return route('admin.rp.manage.roles');
    }
    public function update(Request $request) {
        $role_id = $request->validate(['role_id'=>'required|exists:roles,id'])['role_id'];
        $data = $request->validate([
            'title'=>"sometimes|max:255|unique:roles,title,$role_id",
            'slug'=>"sometimes|max:255|unique:roles,slug,$role_id",
            'description'=>'sometimes|max:2000'
        ]);

        $role = Role::find($role_id);
        $role->update($data);

        Session::flash('message', 'Role informations have been updated successfully.');
        return route('admin.rp.manage.roles', ['role'=>$role->refresh()->slug]);
    }
    public function delete(Request $request) {
        $role_id = $request->validate(['role_id'=>'required|exists:roles,id'])['role_id'];
        // Get role and its permissions (ids)
        $role = Role::find($role_id);
        $permissions = $role->permissions()->pluck('id');

        if($role->slug == 'site-owner')
            abort(422, 'Site owner role could not be deleted');

        // Before deleting the role, we have to detach all its permissions from members who own this role         
        foreach(User::findMany($role->users()->pluck('id')) as $user) $user->permissions()->detach($permissions);

        $role->delete();

        Session::flash('message', 'Role has been deleted successfully.');
    }
    public function attach_permissions(Request $request) {
        $data = $request->validate([
            'role'=>'required|exists:roles,id',
            'permissions'=>'required',
            'permissions.*'=>'exists:permissions,id'
        ]);

        $role = Role::find($data['role']);
        // Before attach permissions to role, we need to attach them to role owners first
        foreach($role->users as $user) $user->permissions()->syncWithoutDetaching($data['permissions']);
        // Then we attach permissions to role
        $role->permissions()->syncWithoutDetaching($data['permissions']);

        Session::flash('message', 'Permissions have been attached to "' . $role->title . '" role successfully.');
    }
    public function detach_permissions(Request $request) {
        $data = $request->validate([
            'role'=>'required|exists:roles,id',
            'permissions'=>'required',
            'permissions.*'=>'exists:permissions,id'
        ]);

        $role = Role::find($data['role']);
        // Before detach permissions from role, we need to detach them from role owners first
        foreach($role->users as $user) $user->permissions()->detach($data['permissions']);
        // Then we detach permissions from role
        $role->permissions()->detach($data['permissions']);

        Session::flash('message', 'Permissions have been detached from "' . $role->title . '" role successfully.');
    }
    public function grant(Request $request) {
        $data = $request->validate([
            'role'=>'required|exists:roles,id',
            'users'=>'required',
            'users.*'=>'exists:users,id'
        ]);

        $role = Role::find($data['role']);
        $permissions = $role->permissions()->pluck('id')->toArray();
        /**
         * Before grant the role to user(s), we need to get all role permissions and
         * attach them to user(s).
         */
        foreach(User::findMany($data['users']) as $user) {
            $user->permissions()->syncWithoutDetaching($permissions);
        }
        
        $role->users()->syncWithPivotValues($data['users'], ['giver_id'=>auth()->user()->id], false);
        Session::flash('message', "Role '$role->title' has been granted to users successfully.");
    }
    public function revoke(Request $request) {
        $data = $request->validate([
            'role'=>'required|exists:roles,id',
            'users'=>'required',
            'users.*'=>'exists:users,id'
        ]);

        $role = Role::find($data['role']);
        $permissions = $role->permissions()->pluck('id')->toArray();
        /**
         * Before revoke the role from user(s), we need to get all role permissions and
         * detach them from user(s).
         */
        foreach(User::findMany($data['users']) as $user) {
            $user->permissions()->detach($permissions);
        }

        $role->users()->detach($data['users']);
        Session::flash('message', "Role '$role->title' has been revoked from user(s) successfully.");
    }
}
