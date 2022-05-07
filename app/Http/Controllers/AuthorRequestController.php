<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuthorRequest;
use App\Models\Category;

class AuthorRequestController extends Controller
{
    public function index(Request $request) {
        $categories = Category::tree()->get()->toTree();

        return view('author-request')
            ->with(compact('categories'));
    }

    public function request(Request $request) {
        $data = $this->validate($request, [
            'categories'=>'required',
            'categories.*'=>'exists:categories,id',
            'message'=>'required|max:3500',
        ], [
            'categories.*'=>__('One of the categories selected not found'),
            'message.max'=>__('Message is too long')
        ]);

        $this->authorize('request', [AuthorRequest::class]);
        
        $data['categories'] = implode(',', $data['categories']);
        $data['user_id'] = auth()->user()->id;
        AuthorRequest::create($data);
    }
}
