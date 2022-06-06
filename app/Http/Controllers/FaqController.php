<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(Request $request) {
        /**
         * We check for live attribute because when normal user submit a question the default value of live column is 0
         * and so it is not shown directly to FAQs page until an admin review it
         */
        $faqs = Faq::where('status', 1)->orderBy('priority')->paginate(8);
        return view('faqs')
            ->with(compact('faqs'));
    }

    public function store(Request $request) {
        $this->authorize('store', [Faq::class]);

        $data = $request->validate([
            'question'=>'required|min:10|max:500',
            'description'=>'sometimes|max:1000'
        ]);
        $data['user_id'] = auth()->user()->id;
        // Faq priority is set to 1000 by default to set it at the end of order

        Faq::create($data);
        \Session::flash('message', __('Your question has been sent successfully'));
    }

    /**
     * Admin section
     */
    public function manage(Request $request) {
        return view('admin.faqs.manage');
    }
}
