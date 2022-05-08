<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(Request $request) {

    }

    public function store(Request $request) {
        $this->authorize('store', [Faq::class]);

        $data = $request->validate([
            'question'=>'required|min:10|max:400',
            'description'=>'sometimes|max:2000'
        ]);
        $data['user_id'] = auth()->user()->id;
        $data['priority'] = 10000; // This make it appear at the end (order) in admin section

        Faq::create($data);
        \Session::flash('message', __('Your question has been sent successfully'));
    }
}
