<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

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
        Role::create($data);

        \Session::flash('message', 'Role "' . $data['title'] . '" has been created successfully. Now you can attach some permissions to that role and give it to users');
    }
}