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
            'question'=>'required|min:10|max:500',
            'description'=>'sometimes|max:2000'
        ]);
        $data['user_id'] = auth()->user()->id;
        // Faq priority is set to 1000 by default to set it at the end of order

        Faq::create($data);
        \Session::flash('message', __('Your question has been sent successfully'));
    }
}
