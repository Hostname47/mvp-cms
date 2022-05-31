<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function store(Request $request) {
        $this->authorize('store', [Permission::class]);

        $data = $request->validate([
            'title'=>'required|max:255|unique:permissions,title',
            'slug'=>'required|max:255|unique:permissions,slug',
            'description'=>'required|max:2000',
            'scope'=>'required|max:455'
        ]);

        $permission = Permission::create($data);
        Session::flash('message', 'Permission "' . $permission->title . '" has been created successfully.');
    }
    public function update(Request $request) {
        $this->authorize('update', [Permission::class]);

        $permission_id = $request->validate(['permission_id'=>'required|exists:permissions,id'])['permission_id'];
        $data = $request->validate([
            'title'=>"sometimes|max:255|unique:permissions,title,$permission_id",
            'slug'=>"sometimes|max:255|unique:permissions,slug,$permission_id",
            'description'=>'sometimes|max:2000',
            'scope'=>'sometimes|max:455'
        ]);

        $permission = Permission::find($permission_id);
        $permission->update($data);

        Session::flash('message', 'Permission informations have been updated successfully.');
    }
    public function delete(Request $request) {
        $this->authorize('delete', [Permission::class]);

        $permission_id = $request->validate(['permission_id'=>'required|exists:permissions,id'])['permission_id'];
        // Get role and delete it as well
        $permission = Permission::find($permission_id);
        $permission->delete();

        Session::flash('message', 'Permission "' . $permission->title . '" has been deleted successfully.');
        return route('admin.rp.manage.permissions');
    }
    public function attach_permissions_to_users(Request $request) {
        $this->authorize('attach_permission_to_user', [Permission::class]);

        $data = $request->validate([
            'permissions'=>'required',
            'permissions.*'=>'exists:permissions,id',
            'users'=>'required',
            'users.*'=>'exists:users,id'
        ]);

        foreach(Permission::findMany($data['permissions']) as $permission)
            $permission->users()->syncWithoutDetaching($data['users']);

        Session::flash('message', 'Permissions have been attached to users successfully.');
    }
    public function detach_permissions_from_users(Request $request) {
        $this->authorize('detach_permission_from_user', [Permission::class]);

        $data = $request->validate([
            'permissions'=>'required',
            'permissions.*'=>'exists:permissions,id',
            'users'=>'required',
            'users.*'=>'exists:users,id'
        ]);

        foreach(Permission::findMany($data['permissions']) as $permission)
            $permission->users()->detach($data['users']);

        Session::flash('message', 'Permissions has been detached from users successfully.');
    }
}
