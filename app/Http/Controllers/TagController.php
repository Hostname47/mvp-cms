<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Tag};

class TagController extends Controller
{
    public function manage(Request $request) {
        $k = '';
        $tags = Tag::query();

        if($request->has('k')) {
            $k = $request->validate(['k'=>'max:1200'])['k'];
            $tags = Tag::where('title', 'like', "%$k%")
                ->orWhere('slug', 'like', "%$k%");
        }

        $tags = $tags->paginate(12);

        return view('admin.tags.manage')
            ->with(compact('k'))
            ->with(compact('tags'));
    }
}
