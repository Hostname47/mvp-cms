<?php

namespace App\View\Components\Post;

use Illuminate\View\Component;
use Illuminate\Http\Request;
use App\Models\Post;

class FeaturedPosts extends Component
{
    public $posts;

    public function __construct(Request $request)
    {
        /**
         * For now we'll take featured posts based on claps, but later after implementing
         * post views and reactions, we'll update it. Also the following query should be
         * cached for sake of multi-usage (in header discover section and side bars).
         * 
         * Also we need to make featured posts to be flexible to match featured posts that 
         * belong to the a specific cateory if the user is within a speciic category
         */
        $this->posts = Post::featured_posts()->take(6);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.post.featured-posts');
    }
}
