<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    const PER_DAY_MAXIMUM = 10;

    public function store(Request $request) {
        if(Auth::check()) {
            $data = $request->validate(['message'=>'required|max:2000']);
            $data['user_id'] = auth()->user()->id;
        } else {
            $data = $request->validate([
                'firstname'=>'required|alpha|max:100',
                'lastname'=>'required|alpha|max:100',
                'email'=>'required|email|max:320',
                'message'=>'required|max:2000'
            ]);
        }

        /**
         * Notice that we cannot use a policy here because guest users also could send messages
         *
         * If the user is authenticated we see if he already sent PER_DAY_MAXIMUM records today; if so we prevent sending
         * If the user is a guest we check the same condition with ip address
         */
        if(Auth::check()) {
            if(auth()->user()->contact_messages()->count() >= self::PER_DAY_MAXIMUM) {
                abort(403, __("You have a limited number of messages per day") . '.(' . self::PER_DAY_MAXIMUM . ' ' . __('messages') . ')');
            }
        } else {
            if(ContactMessage::today()->where('ip', $request->ip())->count() >= self::PER_DAY_MAXIMUM) {
                abort(403, __("You have a limited number of messages per day") . '(' . self::PER_DAY_MAXIMUM . ' ' . __('messages') . ')');
            }
        }
        // For data storage limit protection
        if(ContactMessage::today()->count() >= 5000)
            abort(403, __("We have received many messages today, If you think your message is too important to review, you can send it to us tomorrow"));
        
        $data['ip'] = $request->ip();

        ContactMessage::create($data);
        \Session::flash('message', __('Your message has been sent successfully') . ' !');
    }
}
