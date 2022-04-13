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
}
