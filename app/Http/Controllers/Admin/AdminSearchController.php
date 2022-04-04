<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Post};
use Carbon\Carbon;

class AdminSearchController extends Controller
{
    public function posts_search(Request $request) {
        $query = $request->validate(['k'=>'required|max:1000'])['k'];
        $n = 10;

        $result = Post::withoutGlobalScopes()
            ->where('id', $query)
            ->orWhere('title', 'LIKE', "%$query%")
            ->orWhere('slug', 'LIKE', "%$query%")
            ->take($n+1)->get();

        $hasmore = $result->count() > $n;
        $result = $result->take($n)->map(function($post) {
            return [
                'id'=>$post->id,
                'title'=>$post->title,
                'author_name'=>$post->author->fullname,
                'creation_date'=>(new Carbon($post->created_at))->isoFormat("DD-MM-YYYY - H:mm A"),
                'editlink'=>route('edit.post', ['post'=>$post->id])
            ];
        });

        return [
            'posts'=>$result->take(10),
            'hasmore'=>$result->count() > 10,
        ];
    }
}
