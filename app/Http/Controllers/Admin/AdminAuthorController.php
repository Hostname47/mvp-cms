<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthorController extends Controller
{
    public function overview(Request $request) {
        return view('admin.author.overview');
    }
}
