<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\View\Components\User\Activities\Sections\ClapedPostsSection;

class ActivitiesController extends Controller
{
    const SECTIONS = ['claped-posts', 'saved-posts', 'comments', 'corrections'];

    public function activities(Request $request) {
        $user = auth()->user();
        $section = 'claped-posts';
        if($request->has('section')) {
            $section = $this->validate($request, [
                'section'=>[Rule::in(self::SECTIONS)]
            ], [
                'section.in' => __('The selected section is invalid') . '.'
            ])['section'];
        }

        return view('user.activities')
            ->with(compact('section'))
            ->with(compact('user'));
    }
}
