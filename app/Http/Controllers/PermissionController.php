<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'title'=>'required|max:255|unique:permissions,title',
            'slug'=>'required|max:255|unique:permissions,slug',
            'description'=>'required|max:2000',
            'scope'=>'required|max:455'
        ]);

        $permission = Permission::create($data);
        Session::flash('message', 'Permission "' . $permission->title . '" has been created successfully. Now you can attach it to a role or grant it directly to users');
    }
    public function update(Request $request) {
        $permission_id = $request->validate(['permission_id'=>'required|exists:permissions,id'])['permission_id'];
        $data = $request->validate([
            'title'=>"sometimes|max:255|unique:permissions,title,$permission_id",
            'slug'=>"sometimes|max:255|unique:permissions,slug,$permission_id",
            'description'=>'sometimes|max:2000',
            'scope'=>'sometimes|max:455'
        ]);

        $permission = Permission::find($permission_id);
        $permission->update($data);

        Session::flash('message', 'Permission has been updated successfully.');
    }
    public function delete(Request $request) {
        $permission_id = $request->validate(['permission_id'=>'required|exists:permissions,id'])['permission_id'];
        // Get role and delete it as well
        Permission::find($permission_id)->delete();

        Session::flash('message', 'Permission has been deleted successfully.');
    }
}
