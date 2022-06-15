<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\AuthorRequest;
use App\Models\Category;
use Purifier;

class AuthorRequestController extends Controller
{
    public function index(Request $request) {
        $categories = Category::tree()->get()->toTree();
        $application = auth()->user() ? AuthorRequest::where('user_id', auth()->user()->id)->first() : null;
        $status = 'not-yet';

        if($application) {
            switch($application->status) {
                case -1:
                    $status = 'refused';
                    break;
                case 0:
                    $status = 'under-review';
                    break;
                case 1:
                    $status = 'approved';
                    break;
            }
        }

        return view('author-request')
            ->with(compact('categories'))
            ->with(compact('application'))
            ->with(compact('status'));
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

        $data['message'] = Purifier::clean($data['message']);
        $data['categories'] = implode(',', $data['categories']);
        $data['user_id'] = auth()->user()->id;
        AuthorRequest::create($data);
    }
}
