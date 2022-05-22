<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\{Post,Category,Tag,SavedPost};
use App\View\Components\Post\PostCard;
use Cookie;

class PostController extends Controller
{
    public function view(Request $request, Category $category, Post $post) {
        $link = route('view.post', ['category'=>$category->slug, 'post'=>$post->slug]);
        $title = $post->html_title;
        $saved = $post->saved;
        if($post->visibility != 'password-protected' || Cookie::has('post-'.$post->id.'-password')) {
            $post->increment('views');
        }
        
        return view('view-post')
            ->with(compact('category'))
            ->with(compact('post'))
            ->with(compact('title'))
            ->with(compact('link'))
            ->with(compact('saved'));
    }

    public function unlock(Request $request) {
        $data = $request->validate([
            'post_id'=>'required|exists:posts,id',
            'password'=>'required|max:256'
        ]);
        $post = Post::find($data['post_id']);

        /**
         * Notice that we cannot use policies because guest users are also allowed
         * to access those locked posts if they have the password
         */
        if(is_null($post))
            abort(404, __('Post not found'));

        if($post->visibility != 'password-protected')
            abort(403, __('Post already available and does not require a password.'));

        if($data['password'] != $post->metadata['password'])
            abort(401, __('Invalid password, try again.'));
        
        /** If user provide a valid password we store a cookie for 120 minutes that allow that user to access the post */    
        $cookie = Cookie::make('post-'.$post->id.'-password', $data['password'], 120);

        return redirect($post->link)->withCookie($cookie);
    }

    public function save(Request $request) {
        $data = [
            'post_id'=>$request->validate(['post_id'=>'required|exists:posts,id'])['post_id'],
            'user_id'=>auth()->user()->id
        ];

        // Check if user already save this post
        $already = SavedPost::where('user_id', auth()->user()->id)->where('post_id', $data['post_id'])->first();
        if($already) {
            $already->delete();
            return 0;
        } else {
            SavedPost::create($data);
            return 1;
        }
    }

    public function fetch(Request $request) {
        $data = $request->validate([
            'skip'=>'required|numeric',
            'take'=>'required|numeric',
            'sort'=>['required', Rule::in(['publish-date','views','comments','reactions'])],
            'form'=>['required', Rule::in(['raw','card-component'])],
        ]);

        $sortby = '';
        switch($data['sort']) {
            case 'publish-date':
                $sortby = 'published_at desc';
                break;
            case 'views':
                $sortby = 'views desc';
                break;
            case 'comments':
                $sortby = 'comments_count desc';
                break;
            case 'reactions':
                $sortby = 'reactions_count desc';
                break;
        }

        $posts = Post::with(['categories', 'author', 'author.roles', 'tags'])
            ->orderByRaw($sortby)->skip($data['skip'])->take($data['take']+1)->get();
        $hasmore = $posts->count() > $data['take'];
        $posts = $posts->take($data['take']);
        $payload = "";
        switch($data['form']) {
            case 'raw':
                $payload = $posts->map(function($post) {
                    return [
                        'id'=>$post->id,
                        // The other neccessary columns
                    ];
                });
                break;
            case 'card-component':
                $posts->map(function($post) use (&$payload) {
                    $postcard = (new PostCard($post));
                    $postcard = $postcard->render(get_object_vars($postcard))->render();
                    $payload .= $postcard;
                });
                break;
        }

        return [
            'posts'=>$payload,
            'count'=>$posts->count(),
            'hasmore'=>$hasmore
        ];
    }
}
