<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\{Tag};
use App\Helpers\Search;
use Purifier;

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
        $this->authorize('store', [Tag::class]);

        $data = $this->validate($request, [
            'title'=>'required|unique:tags,title|max:600',
            'title_meta'=>'required|unique:tags,title_meta|max:600',
            'slug'=>'required|unique:tags,slug|max:1000',
            'description'=>'sometimes|max:4000'
        ], [
            'title.unique'=>'Tag title is already taken',
            'slug.unique'=>'Tag slug is already taken',
        ]);
        if(!isset($data['description'])) $data['description'] = '--';

        $tag = Tag::create($data);

        return [
            'id'=>$tag->id,
            'title'=>$tag->title,
            'title_meta'=>$tag->title_meta,
            'slug'=>$tag->slug,
            'description'=>$tag->description,
            'link'=>''
        ];
    }
    public function data(Request $request) {
        $tag_id = $request->validate(['tag'=>'required|exists:tags,id'])['tag'];

        return Tag::find($tag_id);
    }
    public function update(Request $request) {
        $this->authorize('update', [Tag::class]);

        $tag_id = $request->validate(['tag_id'=>'required|exists:tags,id'])['tag_id'];
        $data = $request->validate([
            'title'=>"sometimes|unique:tags,title,$tag_id|min:2|max:600",
            'title_meta'=>"sometimes|unique:tags,title_meta,$tag_id|min:2|max:600",
            'slug'=>"sometimes|min:2|unique:tags,slug,$tag_id|max:1000",
            'description'=>'sometimes|max:4000',
        ]);

        $tag = Tag::find($tag_id);
        $tag->update($data);
    }
    public function delete(Request $request) {
        $this->authorize('delete', [Tag::class]);

        $tag_id = $request->validate(['tag_id'=>'required|exists:tags,id'])['tag_id'];
        Tag::find($tag_id)->delete();
    }

    /**
     * Client
     */
    public function index(Request $request) {
        $k = null;
        $perpage = 16;
        $tags = Tag::query();
        if($request->has('k')) {
            $k = Purifier::clean($request->get('k'));
            $tags = Search::search($tags, $k, ['title','title_meta','slug'], ['like','like','like']);
        }

        $tags = $tags->orderBy('slug')->paginate($perpage);
        $hasmore = $tags->hasMorePages();

        return view('tags.index')
            ->with(compact('tags'))
            ->with(compact('hasmore'))
            ->with(compact('k'));
    }

    public function view(Tag $tag) {
        $posts = collect([]);
        $perpage = 10;

        if($tag)
            $posts = $tag->posts()->with(['author','tags','categories'])->paginate($perpage);

        return view('tags.view')
            ->with(compact('tag'))
            ->with(compact('posts'));
    }
}
