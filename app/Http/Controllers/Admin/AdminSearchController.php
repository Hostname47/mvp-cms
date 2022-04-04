<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Post};
use Carbon\Carbon;

class AdminSearchController extends Controller
{
    public function posts_search(Request $request) {
        $data = $request->validate([
            'k'=>'required|max:2000',
            'skip'=>'sometimes|numeric',
            'take'=>'sometimes|numeric',
        ]);
        
        $query = $data['k'];
        $skip = isset($data['skip']) ? $data['skip'] : 0;
        $take = isset($data['take']) ? $data['take'] : 10;

        $result = Post::withoutGlobalScopes()
            ->where('id', $query)
            ->orWhere('title', 'LIKE', "%$query%")
            ->orWhere('slug', 'LIKE', "%$query%")
            ->orderBy('created_at', 'desc')
            ->take($take+1)->skip($skip)->get();

        $hasmore = $result->count() > $take;
        $result = $result->take($take)->map(function($post) {
            return [
                'id'=>$post->id,
                'title'=>$post->title,
                'author_name'=>$post->author->fullname,
                'creation_date'=>(new Carbon($post->created_at))->isoFormat("DD-MM-YYYY - H:mm A"),
                'editlink'=>route('edit.post', ['post'=>$post->id])
            ];
        });

        return [
            'posts'=>$result,
            'hasmore'=>$hasmore,
        ];
    }
}
