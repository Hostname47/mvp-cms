<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,Tag};

class TagTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create_a_tag()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

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
        $user = User::factory()->create();
        $this->actingAs($user);
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
        $user = User::factory()->create();
        $this->actingAs($user);
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
}
