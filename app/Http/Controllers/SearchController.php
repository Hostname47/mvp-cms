<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{User,Post,Tag,Role,Category,CategoryPost};
use App\Helpers\Search;
use Purifier;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function search(Request $request) {
        $data = $this->validate($request, [
            'k'=>'sometimes|max:450',
            'type'=>['sometimes', Rule::in(['all','posts','authors','tags'])]
        ], [
            'k.max'=>__('Your search query is too long')
        ]);

        $k = null;
        $type = $data['type'] ?? 'all';
        $authors = collect([]);
        $tags = collect([]);
        $posts = collect([]);
        $hasmore = ['authors'=>false, 'tags'=>false, 'posts'=>false];
        
        if($request->has('k')) {
            // protect against xss
            $k = Purifier::clean($request->get('k'));
            $length = ['authors'=>4, 'tags'=>6, 'posts'=>10];

            switch($type) {
                case 'authors':
                    $authors = Search::search(Role::where('slug', 'author')->first()->users(), $k, ['firstname','lastname','username'], ['like','like','like'])
                        ->paginate($length['authors']);
                    $hasmore['authors'] = $authors->hasMorePages();
                    break;
                case 'tags':
                    /**
                     * We only get tags if the search query contains only one keyword
                     */
                    $tags = Search::search(Tag::query(), $k, ['title','slug'], ['like','like'])
                        ->paginate($length['tags']);
                    $hasmore['tags'] = $tags->hasMorePages();
                    break;
                case 'posts':
                    $posts = Search::search(Post::with(['categories', 'author','author.roles', 'tags']), $k, ['title','slug','content'], ['like','like','like'])
                        ->paginate($length['posts']);
                    $hasmore['posts'] = $posts->hasMorePages();
                    break;
                case 'all':
                    // get authors
                    $authors = Search::search(Role::where('slug', 'author')->first()->users(), $k, ['firstname','lastname','username'], ['like','like','like'])
                        ->paginate($length['authors']);
                    $hasmore['authors'] = $authors->hasMorePages();
                    // get tags
                    $tags = Search::search(Tag::query(), $k, ['title','slug'], ['like','like'])
                        ->paginate($length['tags']);
                    $hasmore['tags'] = $tags->hasMorePages();
                    // get posts
                    $posts = Search::search(Post::with(['categories', 'author','author.roles', 'tags']), $k, ['title','slug','content'], ['like','like','like'])
                        ->paginate($length['posts']);
                    $hasmore['posts'] = $posts->hasMorePages();
                    break;
            }
        }

        return view('search.search')
            ->with(compact('authors'))
            ->with(compact('tags'))
            ->with(compact('posts'))
            ->with(compact('type'))
            ->with(compact('hasmore'))
            ->with(compact('k'));
    }
    public function advanced(Request $request) {
        $categories = Category::tree()->get()->toTree();
        return view('search.advanced')
        ->with(compact('categories'));
    }
    public function advanced_results(Request $request) {
        $data = $request->validate([
            'k'=>'sometimes|max:450',
            'category'=>'sometimes',
            'category.*'=>'nullable|exists:categories,id',
            'date-filter'=>['sometimes',Rule::in(['anytime','past24hours','pastweek','pastmonth'])],
            'sort-filter'=>['sometimes',Rule::in(['published-at-desc','published-at-asc','claps-count','comments-count'])],
        ]);
        $perpage = 10;
        $k = isset($data['k']) ? Purifier::clean($data['k']) : '';
        $posts = Post::with(['categories', 'author','author.roles', 'tags']);
        $filters = [];

        // Category(s) filter (by default we take all categories for search unless the user select)
        $filters['categories'] = [__('Categories'), ['All categories']];

        if(isset($data['category'])) {
            if($data['category'][0] != null) {
                $filters['categories'] = [__('Categories'), Category::findMany($data['category'])->pluck('title')];
                $posts = $posts->whereIn('id', CategoryPost::whereIn('category_id', $data['category'])->pluck('post_id'));            
            }
        }

        // Date filter
        if(isset($data['date-filter'])) {
            switch($data['date-filter']) {
                case 'past24hours':
                    $posts = $posts->where("created_at",">=",Carbon::now()->subDay(1));
                    $filters['date'] = __('Last 24 hours');
                    break;
                case 'pastweek':
                    $posts = $posts->where("created_at",">",Carbon::now()->subDays(7));
                    $filters['date'] = __('Last week');
                    break;
                case 'pastmonth':
                    $posts = $posts->where("created_at",">",Carbon::now()->subMonth());
                    $filters['date'] = __('Last month');
                    break;
                default:
                    $filters['date'] = __('Anytime');
            }
        }

        // Search keywords
        $posts = Search::search($posts, $k, ['title','title_meta','slug','content'], ['like','like','like','like']);

        // Sort filter
        $sort = isset($data['sort-filter']) ? $data['sort-filter'] : 'published-at-desc';
        switch($sort) {
            case 'published-at-desc':
                $posts = $posts->orderBy('published_at', 'desc');
                $filters['sort'] = __('Publish date (newest first)');
                break;
            case 'published-at-asc':
                $posts = $posts->orderBy('published_at');
                $filters['sort'] = __('Publish date (oldest first)');
                break;
            case 'claps-count':
                $posts = $posts->orderBy('reactions_count', 'desc');
                $filters['sort'] = __('Number of claps');
                break;
            case 'comments-count':
                $posts = $posts->orderBy('comments_count', 'desc');
                $filters['sort'] = __('Number of comments');
                break;
        }

        $posts = $posts->paginate($perpage);

        return view('search.advanced-results')
            ->with(compact('posts'))
            ->with(compact('k'))
            ->with(compact('filters'));
    }
    public function authors(Request $request) {
        $k = null;
        $perpage = 10;
        $authors = Role::where('slug', 'author')->first()->users();

        if($request->has('k')) {
            $k = Purifier::clean($request->get('k'));
            $authors = Search::search($authors, $k, ['firstname','lastname','username'], ['like','like','like']);
        }

        $authors = $authors->orderBy('username')->paginate($perpage);
        $hasmore = $authors->hasMorePages();

        return view('search.search-authors')
            ->with(compact('k'))
            ->with(compact('authors'))
            ->with(compact('hasmore'));
    }
    public function fetch_authors(Request $request) {
        $data = $request->validate([
            'k'=>'sometimes|max:450',
            'skip'=>'required|numeric',
            'take'=>'required|numeric',
        ]);

        $take = 10;
        $authors = Role::where('slug', 'author')->first()->users();

        if(isset($data['k'])) {
            $k = Purifier::clean($request->get('k'));
            $authors = Search::search($authors, $k, ['firstname','lastname','username'], ['like','like','like']);
        }
            
        $authors = $authors->orderBy('username')->skip($data['skip'])->take($data['take']+1)->get();
        $hasmore = $authors->count() > $data['take'];
        $authors = $authors->take($data['take'])->map(function($author) {
            return [
                'link'=>'', // Later
                'avatar'=>$author->avatar(100),
                'fullname'=>$author->fullname,
                'username'=>'@'.$author->username,
                'posts_count'=>$author->posts()->count() . ' ' . __('posts'),
            ];
        });

        return [
            'authors'=>$authors,
            'count'=>$authors->count(),
            'hasmore'=>$hasmore
        ];
    }
}
