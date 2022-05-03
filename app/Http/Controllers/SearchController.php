<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{User,Post,Role};
use App\Helpers\Search;
use Purifier;

class SearchController extends Controller
{
    public function search(Request $request) {
        $data = $this->validate($request, [
            'k'=>'sometimes|max:450',
            'type'=>['sometimes', Rule::in(['all','posts','authors'])]
        ], [
            'k.max'=>__('Your search query is too long')
        ]);

        $k = null;
        $type = $data['type'] ?? 'all';
        $posts = collect([]);
        $authors = collect([]);
        $hasmore = ['authors'=>false, 'posts'=>false];
        
        if($request->has('k')) {
            // protect against xss
            $k = Purifier::clean($request->get('k'));
            $length = ['tags'=>10, 'authors'=>4, 'posts'=>10];
            $hasmore = ['tags'=>false, 'authors'=>false, 'posts'=>false];

            switch($data['type']) {
                case 'authors':
                    $author = Role::where('slug', 'author')->first();
                    $authors = Search::search($author->users(), $k, ['firstname','lastname','username'], ['like','like','like'])
                        ->paginate($length['authors']);
                    break;
                case 'posts':
                    $posts = Search::search(Post::query(), $k, ['title','slug','content'], ['like','like','like'])
                        ->paginate($length['posts']);
                    break;
                case 'all':
                    // get authors
                    $authors = Search::search(Role::where('slug', 'author')->first()->users(), $k, ['firstname','lastname','username'], ['like','like','like'])
                    ->paginate($length['authors']);
                    // get posts
                    $posts = Search::search(Post::query(), $k, ['title','slug','content'], ['like','like','like'])
                        ->paginate($length['posts']);
                    break;
            }

            $hasmore = ['authors'=>$authors->total() > $length['authors']];
        }

        return view('search.search')
            ->with(compact('authors'))
            ->with(compact('posts'))
            ->with(compact('type'))
            ->with(compact('hasmore'))
            ->with(compact('k'));
    }
}
