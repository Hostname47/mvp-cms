<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\{Post,Category,Tag};

class PostController extends Controller
{
    public function all(Request $request) {
        $status = 'all';
        if($request->has('status'))
            $status = $request->validate(['status'=>Rule::in(['all', 'published', 'draft', 'private', 'trashed', 'awaiting-review'])])['status'];

        $posts = Post::query();
        switch($status) {
            case 'all':
                $posts = $posts->withoutGlobalScopes();
                break;
            case 'published':
                $posts = $posts->where('status', 'published');
                break;
            case 'draft':
                $posts = $posts->where('status', 'draft');
                break;
            case 'awaiting-review':
                $posts = $posts->where('status', 'awaiting-review');
                break;
            case 'trashed':
                $posts = $posts->onlyTrashed();
                break;
        }
        $posts = $posts->with(['author','categories','tags'])->orderBy('updated_at', 'desc')->paginate(12);

        return view('admin.posts.all')
            ->with(compact('posts'))
            ->with(compact('status'));
    }

    public function view(Request $request, Category $category, Post $post) {
        return view('view-post')
            ->with(compact('post'));
    }

    public function create() {
        return view('admin.posts.create');
    }

    public function store(Request $request) {
        $postdata = $request->validate([
            'title'=>'required|max:1200',
            'title_meta'=>'required|max:1200',
            'slug'=>'required|max:1200',
            'summary'=>'sometimes|max:2000',
            'status'=>['sometimes', Rule::in(['draft', 'published', 'awaiting-review'])],
            'visibility'=>['sometimes', Rule::in(['public', 'private', 'password-protected'])],
            'content'=>'required|max:50000',
            'allow_reactions'=>['sometimes', Rule::in([0, 1])],
            'allow_comments'=>['sometimes', Rule::in([0, 1])],
        ]);
        $postdata['user_id'] = auth()->user()->id;

        // Categories
        $categories = $request->validate([
            'categories'=>'sometimes|min:1|max:10',
            'categories.*'=>'exists:categories,id',
        ]);
        // Tags
        $tags = $request->validate([
            'tags'=>'sometimes|max:36',
            'tags.*'=>'min:1|max:120'
        ]);
        // Featured Image
        $featured_image = $request->validate([
            'featured_image'=>'sometimes|exists:metadata,id'
        ]);
        // Checking if post is password protected
        $password = $request->validate([
            'password'=>'required_if:visibility,password-protected|min:8|max:450',
        ]);

        // Create the post
        $post = Post::create($postdata);

        // Attach categories to the post if the admin select categories
        if(isset($categories['categories']))
            $post->categories()->attach($categories['categories']);
        else // Uncategorized category will be attached to post in case admin does not specify any category
            $post->categories()->attach(Category::where('slug', 'uncategorized')->first()->id);

        // Attach tags to the post
        if(isset($tags['tags'])) {
            foreach($tags['tags'] as $tag) {
                $post->tags()->syncWithoutDetaching(Tag::firstOrCreate(['title'=>$tag], [
                    'title' => $tag,
                    'slug' => Str::slug($tag, '-'),
                    'description' => '--'
                ])->id);
            }
        }

        // Attach featured image to the post
        if(isset($featured_image['featured_image'])) {
            $metadata = $post->metadata;
            $metadata['featured_image'] = $featured_image['featured_image'];
            $post->update(['metadata'=>$metadata]);
        }

        // Create a password for the post if admin specify password locked visibility
        if(isset($password['password'])) {
            $metadata = $post->metadata;
            // $metadata['password'] = Hash::make($password['password']);
            $metadata['password'] = $password['password'];
            $post->update(['metadata'=>$metadata]);
        }

        $flash="";
        if($postdata['status'] == 'draft')
            $flash = 'Post has been created <strong>as draft</strong> successfully.';
        else if($postdata['status'] == 'awaiting-review')
            $flash = 'Post has been created successfully under review. One of the admins will review its content before publish it.';
        else
            $flash = 'Post has been created successfully. <a href="' . route('edit.post', ['post'=>$post->id]) . '" class="link-style">click here</a> to manage the post';

        Session::flash('message', $flash);

        return [
            'id'=>$post->id,
            'editlink' => route('edit.post', ['post'=>$post->id]),
            'previewlink' => route('preview.post', ['post'=>$post->id]),
            'allpostslink' => route('admin.all.posts')
        ];
    }

    public function edit(Request $request) {
        $post = null;
        if($request->has('post'))
            $post = Post::withoutGlobalScopes()->find($request->post);

        return view('admin.posts.edit')
            ->with(compact('post'));
    }

    public function update(Request $request) {
        $postdata = $request->validate([
            'title'=>'required|max:1200',
            'title_meta'=>'required|max:1200',
            'slug'=>'required|max:1200',
            'summary'=>'sometimes|max:2000',
            'visibility'=>['sometimes', Rule::in(['public', 'private', 'password-protected'])],
            'content'=>'required|max:50000',
            'allow_reactions'=>['sometimes', Rule::in([0, 1])],
            'allow_comments'=>['sometimes', Rule::in([0, 1])],
        ]);

        // Get the post
        $post_id = $request->validate(['post_id'=>'required|exists:posts,id'])['post_id'];
        $post = Post::withoutGlobalScopes()->find($post_id);

        /**
         * Here in update, we check if featured_image is set by admin; If so then we update
         * its value to the value specified by admin. In the other hand if the value is missed
         * we need to remove featured_image from the post metadata
         */
        $featured_image = $request->validate([
            'featured_image'=>'sometimes|exists:metadata,id'
        ]);

        $categories = $request->validate([
            'categories'=>'sometimes|min:1|max:10',
            'categories.*'=>'exists:categories,id',
        ]);

        $tags = $request->validate([
            'tags'=>'sometimes|max:36',
            'tags.*'=>'min:1|max:256',
        ]);

        // Checking if post is password locked
        $password = $request->validate([
            'password'=>'required_if:visibility,password-protected|min:8|max:450',
        ]);

        // Update post content and other rlated inputs
        $post->update($postdata);

        // Featured image
        $metadata = $post->metadata;
        if(isset($featured_image['featured_image']))
            $metadata['featured_image'] = $featured_image['featured_image'];
        else
            unset($metadata['featured_image']);
        $post->update(['metadata'=>$metadata]);


        // Check if visibility is password protected to save the password
        if(isset($password['password'])) {
            $metadata = $post->metadata;
            // $metadata['password'] = Hash::make($password['password']);
            $metadata['password'] = $password['password'];
            $post->update(['metadata'=>$metadata]);
        }

        // Update categories by syncing post categories with the new selected ones
        if(isset($categories['categories'])) {
            $post->categories()->sync($categories['categories']);
        }
        
        /**
         * Syncing tags of post with the new ones
         *  1. first detach all tags
         *  2. then attach new selected ones
         */
        if(isset($tags['tags'])) {
            $post->tags()->sync([]); // 1
            foreach($tags['tags'] as $tag) { // 2
                $post->tags()->syncWithoutDetaching(Tag::firstOrCreate(['title'=>$tag], [
                    'title' => $tag,
                    'slug' => Str::slug($tag, '-'),
                    'description' => '--'
                ])->id);
            }
        }

        Session::flash('message', 'Post has been <strong>updated</strong> successfully. <a href="" class="link-style">click here</a> to view the post');
    }

    public function update_status(Request $request) {
        $data = $request->validate([
            'post_id'=>'required|exists:posts,id',
            'status'=>['required', Rule::in(['draft', 'published', 'awaiting-review'])],
        ]);

        $post = Post::withoutGlobalScopes()->find($data['post_id']);
        $post->update(['status'=>$data['status']]);

        Session::flash('message', 'Post status has been updated successfully.');
    }

    public function post_data(Request $request) {
        $post_id = $request->validate(['post_id'=>'required|exists:posts,id'])['post_id'];
        $post = Post::withoutGlobalScopes()->find($post_id);

        return [
            'title'=>$post->title,
            'title_meta'=>$post->title_meta,
            'slug'=>$post->slug,
            'content'=>$post->content,
        ];
    }

    public function preview(Request $request) {
        $post = null;
        if($request->has('post'))
            $post = Post::withoutGlobalScopes()->find($request->get('post'));

        return view('admin.posts.preview')
            ->with(compact('post'));
    }
}
