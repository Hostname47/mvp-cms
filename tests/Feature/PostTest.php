<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Support\Str;
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
        
        parent::tearDown();
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
    }

    /** @test */
    public function create_a_post_with_password_protected_visibility() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post('/admin/posts', [
            'title'=>'pp','title_meta'=>'pp','slug'=>'p-p','content'=>'pp',
            'visibility'=>'password-protected'
        ])->assertRedirect()->assertSessionHasErrors(['password']);

        $this->post('/admin/posts', [
            'title'=>'pp','title_meta'=>'pp','slug'=>'p-p','content'=>'pp',
            'visibility'=>'password-protected',
            'password'=>'short'
        ])->assertRedirect()->assertSessionHasErrors(['password']); // Short password

        $this->post('/admin/posts', [
            'title'=>'pp','title_meta'=>'pp','slug'=>'p-p','content'=>'pp',
            'visibility'=>'password-protected',
            'password'=>'strong-password'
        ])->assertOk();
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
    public function create_a_post_without_category_will_get_uncategorized_category_by_default() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post('/admin/posts', [
            'title' => 'a','title_meta' => 'b','slug' => 'c','content' => 'd',
        ]);
        $post = Post::first();
        $this->assertCount(1, $post->categories);
        $this->assertEquals('uncategorized', $post->categories->first()->slug);
    }

    /** @test */
    public function create_a_post_with_multiple_categories() {
        $user = User::factory()->create();
        $category1 = Category::factory()->create(['title'=>'Technology','slug'=>'technology']);
        $category2 = Category::factory()->create(['title'=>'Lifestyle','slug'=>'lifestyle']);
        $this->actingAs($user);

        $this->post('/admin/posts', [
            'title' => 'fa','title_meta' => 'ka','slug' => 'pa','summary' => 'la','content' => 'de',
            'categories' => [$category1->id, $category2->id]
        ]);
        $post = Post::first();
        $this->assertCount(2, $post->categories);
    }

    /** @test */
    public function create_a_post_with_tags() {
        $user = User::factory()->create();
        $tag1 = Tag::factory()->create(['title'=>'Dark web','slug'=>'dark-web']);
        $this->actingAs($user);

        /**
         * Here dark web tag is already there, so we expect 2 tags to be at the end; Means only
         * devops will get created in the controller method, because dark web tag will be fetched
         * from db by firstOrCreate method
         */
        $this->post('/admin/posts', [
            'title' => 'fa','title_meta' => 'ka','slug' => 'pa','summary' => 'la','content' => 'de',
            'tags' => ['Dark WeB', 'devops']
        ]);
        $post = Post::first();
        $this->assertCount(2, Tag::all());
        $this->assertCount(2, $post->tags);
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
        // The following featured id does not exist, so we expect an error
        $this->post('/admin/posts', [
            'title' => 'Boo','title_meta' => 'boo','slug' => 'boo-foo','summary' => 'boo','content' => 'boo',
            'featured_image' => 8547875
        ])->assertRedirect()->assertSessionHasErrors(['featured_image']);
    }

    /** @test */
    public function creating_post_with_already_created_tags() {
        $user = User::factory()->create();
        $this->actingAs($user);

        Tag::create(['title'=>'mouad', 'title_meta'=>'mouad', 'slug'=>'mouad']);
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

        Tag::create(['title'=>'mouad', 'title_meta'=>'mouad', 'slug'=>'mouad']);
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
    public function create_a_post_with_status() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post('/admin/posts', [
            'title' => 'T','title_meta' => 't','slug' => 'T','content' => 'T',
            'status' => 'draft'
        ]);
        $post = Post::first();
        $this->assertEquals($post->status, 'draft');
    }

    /** @test */
    public function create_a_post_with_no_status_will_be_awaiting_review_by_default() {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $this->post('/admin/posts', [
            'title' => 'AR','title_meta' => 'AR','slug' => 'a-r','content' => 'AR content',
        ]);
        $post = Post::first();
        $this->assertEquals($post->status, 'awaiting-review');
    }

    /** @test */
    public function update_post_content() {
        $user = User::factory()->create();
        $this->actingAs($user);

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
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create();

        $this->patch('/admin/posts', ['title' => 'patched title',])
            ->assertRedirect()
            ->assertSessionHasErrors(['post_id']); // post_id is required to identify the post to update
        $this->patch('/admin/posts', ['post_id' => 548751])
            ->assertRedirect()
            ->assertSessionHasErrors(['post_id']); // post_id does not exist

        $this->patch('/admin/posts', ['post_id'=>$post->id, 'title'=>Str::random(1200)])
            ->assertOk();
        $this->patch('/admin/posts', ['post_id'=>$post->id, 'title'=>Str::random(1201)]) // Length
            ->assertRedirect()->assertSessionHasErrors(['title']);

        $this->patch('/admin/posts', ['post_id'=>$post->id, 'visibility'=>'private'])
            ->assertOk();
        $this->patch('/admin/posts', ['post_id'=>$post->id, 'visibility'=>'proviate'])
            ->assertRedirect()->assertSessionHasErrors(['visibility']);
    }

    /** @test */
    public function update_post_visibility() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post('/admin/posts', [
            'title' => 'foo','title_meta' => 'foo','slug' => 'f-o-o','content' => 'foo content',
        ]);
        $post = Post::first();
        $this->assertTrue($post->visibility == 'public');

        $this->patch('/admin/posts', [
            'post_id'=>$post->id, 'visibility'=>'private'
        ]);
        $post->refresh();
        $this->assertTrue($post->visibility == 'private');

        $this->patch('/admin/posts', [
            'post_id'=>$post->id, 'visibility'=>'password-protected' // Password protected visibility require a password
        ])->assertRedirect()->assertSessionHasErrors(['password']);

        $this->patch('/admin/posts', [
            'post_id'=>$post->id, 'visibility'=>'password-protected', 'password'=>'short' // Short password
        ])->assertRedirect()->assertSessionHasErrors(['password']);

        $this->patch('/admin/posts', [
            'post_id'=>$post->id, 'visibility'=>'password-protected', 'password'=>'strong-password' // Short password
        ])->assertOk();
        $post->refresh();
        $this->assertTrue($post->metadata['password'] == 'strong-password');
    }

    /** @test */
    public function update_post_categories() {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category1 = Category::factory()->create(['title'=>'Technology','slug'=>'technology']);
        $category2 = Category::factory()->create(['title'=>'Lifestyle','slug'=>'lifestyle']);

        $this->post('/admin/posts', [
            'title'=>'fa','title_meta'=>'ka','slug'=>'pa','content'=>'de',
        ]);
        // Here the post will have the default category uncategorized
        $post = Post::first();
        $this->assertCount(1, $post->categories);
        // Then the admin will update post categories
        $this->patch('/admin/posts', [
            'post_id'=>$post->id,
            'categories'=>[$category1->id, $category2->id]
        ]);
        $post->refresh();
        $this->assertCount(2, $post->categories);
        // Notice that uncategorized is not here because the admin sync the post categories with the new ones
        $this->assertTrue('technology' == $post->categories[0]->slug);
        $this->assertTrue('lifestyle' == $post->categories[1]->slug);
    }

    /** @test */
    public function remove_all_post_categories_will_take_uncategorized_as_default() {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category1 = Category::factory()->create(['title'=>'Technology','slug'=>'technology']);
        $category2 = Category::factory()->create(['title'=>'Lifestyle','slug'=>'lifestyle']);

        $this->post('/admin/posts', [
            'title'=>'fa','title_meta'=>'ka','slug'=>'pa','content'=>'de',
            'categories'=>[$category1->id, $category2->id]
        ]);
        // Now the post has 2 categories (tech and lifestyle)
        $post = Post::first();
        $this->assertCount(2, $post->categories);
        $this->patch('/admin/posts', [
            'post_id'=>$post->id,
            'categories'=>[]
        ]);
        // Now we remove all categries, so the post will take the default uncategorized category
        $post->refresh();
        $this->assertCount(1, $post->categories);
        $this->assertTrue('uncategorized'==$post->categories[0]->slug);
    }

    /** @test */
    public function update_post_tags() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tag1 = Tag::create(['title'=>'mouad', 'title_meta'=>'mouad', 'slug'=>'mouad']);
        $tag2 = Tag::create(['title'=>'thomas', 'title_meta'=>'thomas', 'slug'=>'acquinas']);

        $this->post('/admin/posts', [
            'title' => 'a','title_meta' => 'a','slug' => 'a','summary' => 'a','content' => 'a',
            'tags' => [$tag1->title, $tag2->title]
        ]);
        $post = Post::first();
        $this->assertCount(2, $post->tags);

        $this->patch('/admin/posts', [
            'post_id'=>$post->id,
            'tags'=>['holly', 'quran']
        ]);
        $post->refresh();
        $this->assertCount(2, $post->tags);
        $this->assertTrue('holly'==$post->tags[0]->slug);
        $this->assertTrue('quran'==$post->tags[1]->slug);

        $this->patch('/admin/posts', [
            'post_id'=>$post->id,
            'tags'=>[]
        ]);
        $post->refresh();
        $this->assertCount(0, $post->tags);
    }

    /** @test */
    public function update_post_featured_image() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $featured_image0 = UploadedFile::fake()->image('thumbnail_0.png', 30, 80)->size(200);
        $featured_image1 = UploadedFile::fake()->image('thumbnail_1.png', 30, 80)->size(200);
        $this->post('/admin/media-library/upload', ['files'=>[$featured_image0, $featured_image1]]);

        $fi0metadata = Metadata::all()[0];
        $fi1metadata = Metadata::all()[1];

        $this->post('/admin/posts', [
            'title' => 'Foo','title_meta' => 'foo','slug' => 'foo-boo','content' => 'foo',
            'featured_image' => $fi0metadata->id
        ]);
        $post = Post::first();
        $this->assertEquals($fi0metadata->id, $post->metadata['featured_image']);
        
        $this->patch('/admin/posts', [
            'post_id'=>$post->id,
            'featured_image'=>$fi1metadata->id
        ]);
        $post->refresh();
        $this->assertEquals($fi1metadata->id, $post->metadata['featured_image']);

        $this->patch('/admin/posts', [
            'post_id'=>$post->id,
            'featured_image'=>5842557
        ])->assertRedirect()->assertSessionHasErrors(['featured_image']); // INVALIDE featured image metadata id

        /**
         * Here in update phase, If the post has a feautured_image, and the admin remove it from edit ui,
         * then the featured_image_metadata_id will be null in the hidden input. Si in terms of backend,
         * If the featured_image is not present in the request data, or it is null, then the post featured_image
         * will be cleared from post metadata
         */
        $this->patch('/admin/posts', [
            'post_id'=>$post->id,
        ]);
        $post->refresh();
        $this->assertTrue(!isset($post->metadata['featured_image']));
    }

    /** @test */
    public function update_post_comments_and_reactions_switches() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post('/admin/posts', [
            'title'=>'a','title_meta'=>'a','slug'=>'a','content'=>'a',
        ]);
        $post = Post::first();
        $this->assertTrue(1 == $post->allow_comments);
        $this->assertTrue(1 == $post->allow_reactions);

        $this->patch('/admin/posts', [
            'post_id'=>$post->id,
            'allow_comments'=>0,
            'allow_reactions'=>0,
        ]);
        $post->refresh();
        $this->assertTrue(0 == $post->allow_comments);
        $this->assertTrue(0 == $post->allow_reactions);
        $this->patch('/admin/posts', [
            'post_id'=>$post->id,
            'allow_comments'=>9,
            'allow_reactions'=>'invalid',
        ])->assertRedirect()->assertSessionHasErrors(['allow_comments', 'allow_reactions']);
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

    /** @test */
    public function trash_a_post() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::create(['title' => 'foo','title_meta' => 'foo','slug' => 'foo','summary' => 'foo','content' => 'foo']);

        $this->assertNull($post->deleted_at);
        $this->post('/admin/posts/trash', [
            'post_id'=>$post->id
        ]);
        $post->refresh();
        $this->assertNotNull($post->deleted_at);
    }

    /** @test */
    public function untrash_a_post() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::create(['title' => 'foo','title_meta' => 'foo','slug' => 'foo','summary' => 'foo','content' => 'foo']);
        $this->post('/admin/posts/trash', ['post_id'=>$post->id]);
        $post->refresh();
        $this->assertNotNull($post->deleted_at);
        $this->post('/admin/posts/untrash', ['post_id'=>$post->id]);
        $post->refresh();
        $this->assertNull($post->deleted_at);
    }

    /** @test */
    public function delete_a_post_permanently() {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::create(['title' => 'foo','title_meta' => 'foo','slug' => 'foo','summary' => 'foo','content' => 'foo']);
        $this->assertCount(1, Post::all());
        $this->delete('/admin/posts', ['post_id'=>$post->id]);
        $this->assertCount(0, Post::all());
    }
}
