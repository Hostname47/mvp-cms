<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use App\Models\{User, Category, Post, Tag, Metadata};

class PostTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp(): void {
        parent::setUp();

        /**
         * If an admin does not specify a category for the post, then uncategorized category
         * will be attached to the post as a default category.
         */
        Category::factory()->create([
            'title'=>'Uncategorized',
            'slug'=>'uncategorized'
        ]);

        (new Filesystem)->cleanDirectory(storage_path('app/testing'));
    }

    public function tearDown():void {
        (new Filesystem)->cleanDirectory(storage_path('app/testing'));
    }

    /** @test */
    public function creating_a_post() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertCount(0, Post::all());
        $this->post('/admin/posts', [
            'title' => 'cool title',
            'title_meta' => 'cool-title',
            'slug' => 'cool title',
            'summary' => 'hello world',
            'content' => 'hello world',
        ]);
        $this->assertCount(1, Post::all());
        $post = Post::first();
        $this->assertCount(1, $post->categories); // Post will take uncategorized category by default
        $this->assertTrue($post->categories->first()->slug == 'uncategorized');
    }

    /** @test */
    public function create_a_post_within_a_category() {
        $user = User::factory()->create();
        $category = Category::factory()->create([
            'title'=>'Technology',
            'slug'=>'technology'
        ]);
        $this->actingAs($user);

        $this->post('/admin/posts', [
            'title' => 'cool title',
            'title_meta' => 'cool-title',
            'slug' => 'cool title',
            'summary' => 'hello world',
            'content' => 'hello world',
            'categories' => [$category->id]
        ]);
        $post = Post::first();
        $this->assertCount(1, $post->categories); // Post will take uncategorized category by default
        $this->assertTrue($post->categories->first()->slug == 'technology');
    }

    /** @test */
    public function post_creation_data_validation() {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create();

        $this->post('/admin/posts')
            ->assertRedirect()
            ->assertSessionHasErrors(['title', 'title_meta', 'slug', 'content']);
        $this->post('/admin/posts', [
            'title' => 'cool title', 'title_meta' => 'cool-title', 'slug' => 'cool title', 'summary' => 'hello world', 'content' => 'hello world', 'user_id' => $user->id, 'categories'=>[$category->id],
            'status'=> 'invalid-status', 'visibility'=>'invalid-visibility'
        ])->assertRedirect()->assertSessionHasErrors(['status', 'visibility']);
        $this->post('/admin/posts', [
            'title' => 'cool title', 'title_meta' => 'cool-title', 'slug' => 'cool title', 'summary' => 'hello world', 'content' => 'hello world', 'user_id' => $user->id, 'categories'=>[$category->id],
            'status'=> 'published', 'visibility'=>'public'
        ])->assertOk();
    }

    /** @test */
    public function post_can_belong_to_multiple_categories() {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $this->post('/admin/posts', [
            'title' => 'cool title',
            'title_meta' => 'cool-title',
            'slug' => 'cool title',
            'summary' => 'hello world',
            'content' => 'hello world',
            'categories'=>[$category1->id, $category2->id]
        ]);
        $post = Post::first();
        $this->assertCount(2, $post->categories);
    }

    /** @test */
    public function create_a_post_with_featured_image() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $featured_image = UploadedFile::fake()->image('thumbnail.png', 30, 80)->size(200);
        $this->post('/admin/media-library/upload', ['files'=>[$featured_image]]);
        $featured_image_metdata = Metadata::first();
        $this->post('/admin/posts', [
            'title' => 'Foo','title_meta' => 'foo','slug' => 'foo-boo','summary' => 'foo','content' => 'foo',
            'featured_image' => $featured_image_metdata->id
        ]);
        $post = Post::first();
        $this->assertEquals($featured_image_metdata->id, $post->metadata['featured_image']);

        $this->post('/admin/posts', [
            'title' => 'Boo','title_meta' => 'boo','slug' => 'boo-foo','summary' => 'boo','content' => 'boo',
            'featured_image' => 8547875
        ])->assertRedirect()->assertSessionHasErrors(['featured_image']);
    }

    /** @test */
    public function create_a_post_with_tags() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertCount(0, Tag::all());
        $this->post('/admin/posts', [
            'title' => 'a','title_meta' => 'a','slug' => 'a','summary' => 'a','content' => 'a',
            'tags' => ['mouad','nassri']
        ]);
        $this->assertCount(2, Tag::all());
        $post = Post::first();
        $this->assertCount(2, $post->tags);
    }

    /** @test */
    public function creating_post_with_already_created_tags() {
        $user = User::factory()->create();
        $this->actingAs($user);

        Tag::create(['title'=>'mouad', 'slug'=>'mouad']);
        $this->assertCount(1, Tag::all());
        $this->post('/admin/posts', [
            'title' => 'a','title_meta' => 'a','slug' => 'a','summary' => 'a','content' => 'a',
            'tags' => ['mouad']
        ]);
        $this->assertCount(1, Tag::all());
        $post = Post::first();
        $this->assertCount(1, $post->tags);
    }

    /** @test */
    public function creating_post_with_already_created_tag_but_different_case() {
        $user = User::factory()->create();
        $this->actingAs($user);

        Tag::create(['title'=>'mouad', 'slug'=>'mouad']);
        $this->assertCount(1, Tag::all());
        $this->post('/admin/posts', [
            'title' => 'a','title_meta' => 'a','slug' => 'a','summary' => 'a','content' => 'a',
            'tags' => ['Mouad']
        ]);
        $this->assertCount(1, Tag::all());
        $post = Post::first();
        $this->assertCount(1, $post->tags);
    }

    /** @test */
    public function create_post_with_tags_validation() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post('/admin/posts', [
            'title' => 'a','title_meta' => 'a','slug' => 'a','summary' => 'a','content' => 'a',
            'tags' => ['mouad nassri']
        ]);
        $tag = Tag::first();
        $this->assertEquals('mouad-nassri', $tag->slug);

        $this->post('/admin/posts', [
            'title' => 'a','title_meta' => 'a','slug' => 'a','summary' => 'a','content' => 'a',
            'tags' => ['e','a','b','b','b','e','b','b','b', 'b','b','b','b','b','b','b','b','b','b','b','b','b','b','b','b','b','b','b','b','b','b','b','b','b','b','b','b']
        ])->assertRedirect()->assertSessionHasErrors(['tags']); // Exceed the maximum
    }

    /** @test */
    public function update_post_content() {
        $post = Post::factory()->create([
            'title' => 'cool title',
            'title_meta' => 'cool-title',
            'slug' => 'cool title',
            'summary' => 'hello world',
            'content' => 'hello world',
        ]);
        
        $this->assertEquals('cool title', $post->title);
        $this->assertEquals('cool-title', $post->title_meta);
        $this->assertEquals('cool title', $post->slug);
        $this->assertEquals('hello world', $post->summary);
        $this->assertEquals('hello world', $post->content);

        $this->patch('/admin/posts', [
            'post_id'=>$post->id,
            'title' => 'patched title',
            'title_meta' => 'patched-title',
            'slug' => 'patched slug',
            'summary' => 'patched world',
            'content' => 'patched content',
        ]);
        $post->refresh();

        $this->assertEquals('patched title', $post->title);
        $this->assertEquals('patched-title', $post->title_meta);
        $this->assertEquals('patched slug', $post->slug);
        $this->assertEquals('patched world', $post->summary);
        $this->assertEquals('patched content', $post->content);
    }

    /** @test */
    public function update_post_content_validation() {
        $post = Post::factory()->create([
            'title' => 'cool title',
            'title_meta' => 'cool-title',
            'slug' => 'cool title',
            'summary' => 'hello world',
            'content' => 'hello world',
        ]);

        $this->patch('/admin/posts', ['title' => 'patched title',])
            ->assertRedirect()
            ->assertSessionHasErrors(['post_id']); // post_id is required to identify the post to update
        $this->patch('/admin/posts', ['post_id' => 548751])
            ->assertRedirect()
            ->assertSessionHasErrors(['post_id']); // post_id does not exist
    }

    /** @test */
    public function update_post_status() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post('/admin/posts', [
            'title' => 'foo','title_meta' => 'foo','slug' => 'foo','summary' => 'foo','content' => 'foo',
        ]);
        $post = Post::first();
        $this->assertTrue($post->status == 'awaiting-review');
        $this->patch('/admin/posts/status', [
            'post_id'=>$post->id,
            'status'=>'published'
        ]);
        $post->refresh();
        $this->assertTrue($post->status == 'published');
    }
}
