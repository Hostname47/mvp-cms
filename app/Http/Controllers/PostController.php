<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\{Post,Category,Tag};

class PostController extends Controller
{
    public function all(Request $request) {
        $status = 'all';
        if($request->has('status')) {
            $s = $request->validate(['status'=>Rule::in(['published', 'draft', 'private'])])['status'];
            $status = $s;
        }
        $posts = Post::with('author', 'categories')->orderBy('updated_at', 'desc')->paginate(16);

        return view('admin.posts.all')
            ->with(compact('posts'));
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
        // Checking if post is password locked
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
                $post->tags()->attach(Tag::firstOrCreate(['title'=>$tag], [
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
            $metadata['password'] = Hash::make($password['password']);
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
            'post_id'=>'required|exists:posts,id',
            'title'=>'required|max:1200',
            'title_meta'=>'required|max:1200',
            'slug'=>'required|max:1200',
            'summary'=>'sometimes|max:2000',
            'status'=>['sometimes', Rule::in(['draft', 'published', 'awaiting-review'])],
            'visibility'=>['sometimes', Rule::in(['public', 'private', 'password-locked'])],
            'content'=>'required|max:50000',
            'allow_reactions'=>['sometimes', Rule::in([0, 1])],
            'allow_comments'=>['sometimes', Rule::in([0, 1])],
        ]);

        $categories = $request->validate([
            'categories'=>'sometimes|min:1|max:10',
            'categories.*'=>'exists:categories,id',
        ]);

        $post = Post::withoutGlobalScopes()->find($postdata['post_id']);
        unset($postdata['post_id']);
        $post->update($postdata);

        Session::flash('message', 'Post has been <strong>updated</strong> successfully. <a href="" class="link-style">click here</a> to view the post');
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
