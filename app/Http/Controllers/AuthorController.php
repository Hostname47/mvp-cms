<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function dashboard(Request $request) {
        return view('user.author.author-dashboard');
    }
}
