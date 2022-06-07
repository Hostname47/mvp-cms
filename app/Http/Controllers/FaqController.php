<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(Request $request) {
        /**
         * We check for live attribute because when normal user submit a question the default value of live column is 0
         * and so it is not shown directly to FAQs page until an admin review it
         */
        $faqs = Faq::where('live', 1)->orderBy('priority')->paginate(8);
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
        $faqs = collect([]);
        $tab = 'live';
        if($request->has('tab')) {
            $tab = $request->validate(['tab'=>Rule::in(['live','unverified'])])['tab'];
        }

        switch($tab) {
            case 'live':
                $faqs = Faq::with(['user'])->where('live', 1)->orderBy('priority')->paginate(16);
                break;
            case 'unverified':
                $faqs = Faq::with(['user'])->where('live', 0)->orderBy('created_at', 'desc')->paginate(16);
                break;
        }
        
        return view('admin.faqs.manage')
            ->with(compact('tab'))
            ->with(compact('faqs'));
    }

    public function update_priorities(Request $request) {
        $data = $request->validate([
            'faqs'=>'required',
            'faqs.*'=>'exists:faqs,id',
            'priorities'=>'required',
            'priorities.*'=>'numeric',
        ]);

        $this->authorize('update_priorities', [Faq::class, $data]);
        
        $i = 0;
        foreach($data['faqs'] as $id) {
            Faq::find($id)->update(['priority'=>$data['priorities'][$i]]);
            $i++;
        }

        \Session::flash('message', 'Faqs priorities updated successfully.');
    }

    public function update(Request $request) {
        $data = $request->validate([
            'faq_id'=>'required|exists:faqs,id',
            'question'=>'sometimes|min:1|max:2000',
            'answer'=>'sometimes|min:1|max:20000',
            'live'=>['sometimes', Rule::in([0, 1])]
        ]);

        $this->authorize('update', [Faq::class]);

        $faq = Faq::find($data['faq_id']);
        unset($data['faq_id']);
        
        if(isset($data['live'])) {
            if($data['live']==1) {
                $data['description'] = null;
                \Session::flash('message', 'FAQ <span class="blue">"' . $faq->questionslice . '"</span> is live now.');
            } else
                \Session::flash('message', 'FAQ <span class="blue">"' . $faq->questionslice . '"</span> is idle now and hidden from users in faqs page.');
        }
        
        $faq->update($data);
    }

    public function delete(Request $request) {
        $this->authorize('delete', [Faq::class]);
        $id = $request->validate(['faq_id'=>'required|exists:faqs,id'])['faq_id'];
        
        Faq::find($id)->delete();
    }
}
