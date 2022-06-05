<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Auth;
use Purifier;

class ContactController extends Controller
{
    const PER_DAY_LIMIT = 10;

    public function contact(Request $request) {
        $limit_reached = false;
        $limit_message = __("You have reached your limited number of messages per day. If you have more messages, and you think it's important to be sent, please try again later.");

        if(Auth::check()) {
            if(auth()->user()->contact_messages()->count() >= self::PER_DAY_LIMIT)
                $limit_reached = true;
        } else {
            if(ContactMessage::today()->where('ip', $request->ip())->count() >= self::PER_DAY_LIMIT)
                $limit_reached = true;
        }
        return view('contact')
        ->with(compact('limit_reached'))
        ->with(compact('limit_message'));
    }

    public function store(Request $request) {
        if(Auth::check()) {
            $data = $request->validate(['message'=>'required|min:10|max:4000']);
            $data['message'] = Purifier::clean($data['message']);
            $data['user_id'] = auth()->user()->id;
        } else {
            $data = $request->validate([
                'firstname'=>'required|alpha|max:100',
                'lastname'=>'required|alpha|max:100',
                'email'=>'required|email|max:320',
                'message'=>'required|min:10|max:4000'
            ]);

            foreach($data as $k => $v) $data[$k] = Purifier::clean($v);
        }

        /**
         * Notice that we cannot use a policy here because guest users also could send messages
         *
         * If the user is authenticated we see if he already sent PER_DAY_LIMIT records today; if so we prevent sending
         * If the user is a guest we check the same condition with ip address
         */
        if(Auth::check()) {
            if(auth()->user()->contact_messages()->count() >= self::PER_DAY_LIMIT) {
                abort(403, __("You have reached your limited number of messages per day. If you have more messages, and you think it's important to be sent, please try again later."));
            }
        } else {
            if(ContactMessage::today()->where('ip', $request->ip())->count() >= self::PER_DAY_LIMIT) {
                abort(403, __("You have reached your limited number of messages per day. If you have more messages, and you think it's important to be sent, please try again later."));
            }
        }
        // For data storage limit protection
        if(ContactMessage::today()->count() >= 5000)
            abort(403, __("We have received many messages today, If you think your message is too important to review, you can send it to us later"));
        
        $data['ip'] = $request->ip();

        ContactMessage::create($data);
        \Session::flash('message', __('Your message has been sent successfully') . ' !');
    }

    /**
     * Admin section
     */
    public function manage(Request $request) {
        return view('admin.contact.manage');
    }
}
