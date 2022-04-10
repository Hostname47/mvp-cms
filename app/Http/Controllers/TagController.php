<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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

        $tags = $tags->paginate(16);

        return view('admin.tags.manage')
            ->with(compact('k'))
            ->with(compact('tags'));
    }

    public function store(Request $request) {
        $data = $this->validate($request, [
            'title'=>'required|unique:tags,title|max:600',
            'title_meta'=>'required|max:600',
            'slug'=>'required|unique:tags,slug|max:1000',
            'description'=>'required|max:4000'
        ], [
            'title.unique'=>'Tag title is already taken',
            'slug.unique'=>'Slug is already taken',
        ]);
        Tag::create($data);
        Session::flash('message', 'Tag has been created successfully.');
    }
}
