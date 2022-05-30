<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,Category,Post,Comment,Clap};

class ClapTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;
    public $uncategorized;

    public function setUp():void {
        parent::setUp();
        
        $this->authuser = $authuser = User::factory()->create();
        $this->uncategorized = Category::factory()->create([
            'title'=>'Uncategorized',
            'slug'=>'uncategorized',
            'status'=>'live'
        ]);
        $this->actingAs($authuser);
    }

    /** @test */
    public function clap() {
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $post->categories()->attach($this->uncategorized->id);
        $comment = Comment::factory()->create(['user_id'=>$user->id,'post_id'=>$post->id]);

        $this->assertCount(0, $comment->claps);
        $this->post('/claps', [
            'clapable_id'=>$comment->id,
            'clapable_type'=>'comment'
        ]);
        $this->assertCount(1, $comment->refresh()->claps);
        $this->post('/claps', [
            'clapable_id'=>$comment->id,
            'clapable_type'=>'comment'
        ]);
        $this->assertCount(0, $comment->refresh()->claps);

        // Clap post
        $this->post('/claps', [
            'clapable_id'=>$post->id,
            'clapable_type'=>'post'
        ]);
        $this->assertCount(1, $post->refresh()->claps);
    }

    /** @test */
    public function clap_validation() {
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::factory()->create(['user_id'=>$user->id,'post_id'=>$post->id]);

        $this->post('/claps', ['clapable_id'=>89999, 'clapable_type'=>'comment'])
            ->assertSessionHasErrors(['clapable_id']); // clapable_id invalid

        $this->post('/claps', ['clapable_id'=>$comment->id, 'clapable_type'=>'commentergr'])
            ->assertSessionHasErrors(['clapable_type']); // clapable_type invalid
    }

    /** @test */
    public function clap_a_resource_that_is_not_available_is_not_authorized() {
        $user = $this->authuser;

        $post = Post::factory()->create(['status'=>'draft']);
        $this->post('/claps', ['clapable_id'=>$post->id,'clapable_type'=>'post'])
            ->assertStatus(403);

        $private_post = Post::factory()->create(['status'=>'published', 'visibility'=>'private']);
        $this->post('/claps', ['clapable_id'=>$private_post->id,'clapable_type'=>'post'])
            ->assertStatus(403);
    }

    /** @test */
    public function unauthenticated_user_cannot_clap() { // :p
        $this->post('/logout');
        $post = Post::factory()->create(['status'=>'published']);
        $this->post('/claps', ['clapable_id'=>$post->id,'clapable_type'=>'post'])
            ->assertRedirect();
    }
}
