<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,Tag,Post,Category,Permission};

class TagTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;
    
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

        $permissions = [
            'access-admin-section' => Permission::factory()->create(['title'=>'aas', 'slug'=>'access-admin-section']),
            'create-post' => Permission::factory()->create(['title'=>'cp', 'slug'=>'create-post']),
        ];

        $user = $this->authuser = User::factory()->create();
        $this->actingAs($user);
        $user->attach_permission('access-admin-section');
        $user->attach_permission('create-post');
    }

    /** @test */
    public function create_a_tag()
    {
        $this->assertCount(0, Tag::all());
        $this->post('/admin/tags', [
            'title'=>'Websockets',
            'title_meta'=>'Websockets',
            'slug'=>'websockets',
            'description'=>'websockets desc'
        ]);
        $this->assertCount(1, Tag::all());
    }

    /** @test */
    public function create_tags_validation() {
        Tag::create(['title'=>'foo', 'title_meta'=>'foo', 'slug'=>'f-o-o']);

        $this->post('/admin/tags', [
            'title'=>'foo',
            'title_meta'=>'foo',
            'slug'=>'f-o-o',
        ])->assertRedirect()->assertSessionHasErrors(['title','title_meta','slug']); // Tag already exists with this title, slug and meta title

        $this->post('/admin/tags', [
            'title_meta'=>'foo',
            'slug'=>'f-o-o',
        ])->assertRedirect()->assertSessionHasErrors(['title']); // Title is required

        $this->post('/admin/tags', [
            'title'=>'boo',
            'title_meta'=>'boo',
            'slug'=>'b-o-o',
        ])->assertOk();
        $this->assertEquals('--', Tag::where('slug', 'b-o-o')->first()->description);
    }

    /** @test */
    public function update_a_tag() {
        $tag = Tag::create(['title'=>'foo', 'title_meta'=>'foo', 'slug'=>'f-o-o']);

        $this->patch('/admin/tags', [
            'tag_id'=>$tag->id,
            'title'=>'boo',
            'title_meta'=>'boo',
            'slug'=>'b-o-o',
            'description'=>'boo description'
        ]);
        $tag->refresh();
        $this->assertEquals('boo', $tag->title);
        $this->assertEquals('boo', $tag->title_meta);
        $this->assertEquals('b-o-o', $tag->slug);
        $this->assertEquals('boo description', $tag->description);
    }

    /** @test */
    public function update_a_tag_validation() {
        $tag1 = Tag::create(['title'=>'foo', 'title_meta'=>'foo', 'slug'=>'f-o-o']);
        $tag2 = Tag::create(['title'=>'boo', 'title_meta'=>'boo', 'slug'=>'b-o-o']);

        $this->patch('/admin/tags', [
            'tag_id'=>$tag2->id,
            'title'=>'foo',
            'title_meta'=>'foo',
            'slug'=>'f-o-o',
        ])->assertSessionHasErrors(['title','title_meta','slug']); // Title, title_meta and slug are already exists

        $this->patch('/admin/tags', [
            'tag_id'=>958648,
            'title'=>'inv',
        ])->assertSessionHasErrors(['tag_id']); // Tag id does not exist
    }

    /** @test */
    public function delete_a_tag() {
        $tag = Tag::create(['title'=>'foo', 'title_meta'=>'foo', 'slug'=>'f-o-o']);

        $this->assertCount(1, Tag::all());
        $this->delete('/admin/tags', ['tag_id'=>$tag->id]);
        $this->assertCount(0, Tag::all());
    }

    /** @test */
    public function tag_deletion_checks() {
        $tag = Tag::create(['title'=>'foo', 'title_meta'=>'foo', 'slug'=>'f-o-o']);

        $this->post('/admin/posts', [
            'title' => 'foo',
            'title_meta' => 'foo',
            'slug' => 'foo',
            'content' => 'foo',
            'tags' => ['foo']
        ]);
        // Check if post tags (pivot table) gets deleted on cascading
        $post = Post::first();
        $this->assertCount(1, $post->tags);
        $this->delete('/admin/tags', ['tag_id'=>$tag->id]);
        $this->assertCount(0, $post->refresh()->tags);
    }
}
