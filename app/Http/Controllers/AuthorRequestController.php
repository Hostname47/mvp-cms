<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorRequestController extends Controller
{
    public function index(Request $request) {
        return view('author-request');
    }
}
