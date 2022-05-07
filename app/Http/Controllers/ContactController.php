<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function store(Request $request) {
        if(Auth::check()) {
            $data = $request->validate(['message'=>'required|max:2000']);
            $data['user_id'] = auth()->user()->id;
        } else {
            $data = $request->validate([
                'firstname'=>'required|max:100',
                'lastname'=>'required|max:100',
                'email'=>'required|email|max:320',
                'message'=>'required|max:2000'
            ]);
        }
        $data['ip'] = $request->ip();

        ContactMessage::create($data);
        \Session::flash('message', __('Your message has been sent successfully') . ' !');
    }
}
