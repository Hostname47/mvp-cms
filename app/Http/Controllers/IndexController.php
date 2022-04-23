<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{Post,Category};
use App\Helpers\Search;

class IndexController extends Controller
{
    public function index() {
        return view('index');
    }

    public function discover(Request $request) {
        $count = 8;
        $sort = 'publish-date';
        $category = null;
        $q = null;

        // Handle category if selected
        if($request->has('category')) {
            $slug = $request->validate(['category'=>'exists:categories,slug'])['category'];
            $category = Category::where('slug',$slug)->first();
        }
        /**
         * If the user select a category (valid one), then we need to get posts
         * that belong to that category. Otherwise, we fetch posts normally using
         * post model.
         */
        if(is_null($category))
            $posts = Post::with(['categories', 'author','author.roles', 'tags']);
        else
            $posts = $category->posts()->with(['categories', 'author','author.roles', 'tags']);

        // Handle search if user search for something
        if($request->has('q')) {
            $q = $request->validate(['q'=>'max:2000'])['q'];
            $posts = Search::search($posts, $q, ['title','title_meta','slug','content'], ['like','like','like','like']);
        }

        // Handle posts per page
        if($request->has('count')) {
            $count = $request->validate([
                'count'=>'integer|between:8,20'
            ])['count'];
        }
        // Handle sorting posts by filter
        if($request->has('sort')) {
            $sort = $request->validate([
                'sort'=>Rule::in(['publish-date','views','comments','reactions'])
            ])['sort'];
        }
        switch($sort) {
            case 'publish-date':
                $posts = $posts->orderBy('published_at', 'desc');
                break;
            case 'views':
                // Later when we'll handle posts views
                break;
            case 'comments':
                $posts = $posts->orderBy('comments_count', 'desc');
                break;
            case 'reactions':
                $posts = $posts->orderBy('reactions_count', 'desc');
                break;
        }

        $posts = $posts->take($count+1)->get();
        $hasmore = $posts->count() > $count;
        $posts = $posts->take($count);

        return view('discover')
            ->with(compact('posts'))
            ->with(compact('count'))
            ->with(compact('sort'))
            ->with(compact('q'))
            ->with(compact('category'))
            ->with(compact('hasmore'));
    }
}
