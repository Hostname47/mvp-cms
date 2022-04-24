<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscriber;

class NewsletterController extends Controller
{
    const MAXIMUM = 10;

    public function subscribe(Request $request) {
        if(Auth::check()) {
            if(Subscriber::where('user_id', auth()->user()->id)->orWhere('email', auth()->user()->email)->count())
                abort(403, __("You are already subscribed to our newsletter"));
        } else {
            if(Subscriber::today()->where('ip', $request->ip())->count() >= self::MAXIMUM)
                abort(403, __("Oops something went wrong"));
        }

        $data = [];
        if(Auth::check()) {
            $data['name'] = auth()->user()->fullname;
            $data['email'] = auth()->user()->email;
            $data['user_id'] = auth()->user()->id;
        } else {
            $d = $this->validate($request, [
                'name'=>'required|max:255',
                'email'=>'required|email|unique:subscribers,email|max:300',
            ], [
                'name.max'=>__('Please enter a valid name'),
                'email'=>__('Please enter a valid email address')
            ]);
            $data['email'] = $d['email'];
            $data['name'] = $d['name'];
        }
        $data['ip'] = $request->ip();
        
        Subscriber::create($data);
    }
}
