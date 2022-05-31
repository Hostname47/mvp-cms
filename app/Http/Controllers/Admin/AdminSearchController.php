<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Post,User};
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

    public function users_search(Request $request) {
        $data = $request->validate([
            'k'=>'required|max:2000',
            'skip'=>'sometimes|numeric',
            'take'=>'sometimes|numeric',
        ]);
        
        $query = $data['k'];
        $skip = isset($data['skip']) ? $data['skip'] : 0;
        $take = isset($data['take']) ? $data['take'] : 10;

        $result = User::withoutGlobalScopes()
            ->where('username', 'LIKE', "%$query%")
            ->orderBy('username', 'asc')
            ->take($take+1)->skip($skip)->get();

        $hasmore = $result->count() > $take;
        $result = $result->take($take)->map(function($user) {
            return [
                'id'=>$user->id,
                'fullname'=>$user->fullname,
                'username'=>$user->username,
                'avatar'=>$user->avatar(36),
                'role'=>($hr = $user->high_role()) ? $hr->title : null,
                'rp_management_link'=>route('admin.rp.manage.users', ['user'=>$user->username]),
                'user_management_link'=>route('admin.users.management', ['user'=>$user->username])
            ];
        });

        return [
            'users'=>$result,
            'hasmore'=>$hasmore,
        ];
    }
}
