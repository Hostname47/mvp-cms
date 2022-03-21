<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'title'=>'required|min:2|max:1200',
            'meta_title'=>'required|min:2|max:1200',
            'slug'=>'required|min:2|max:1200',
            'content'=>'required|min:2|max:50000',
            'user_id'=>'required|exists:users,id',
            'category_id'=>'required|exists:categories,id',
        ]);

        Blog::create($data);
    }
}
