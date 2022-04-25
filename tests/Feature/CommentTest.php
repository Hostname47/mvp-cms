<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,Post,Comment};

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

    public function setUp():void {
        parent::setUp();
        
        $this->authuser = $authuser = User::factory()->create();
        $this->actingAs($authuser);
    }

    /** @test */
    public function write_a_comment_on_a_post()
    {
        $post = Post::factory()->create(['status'=>'published']);
        
        $this->assertCount(0, Comment::all());
        $this->post('/comments', [
            'content'=>'hello darkness my old friend',
            'post_id'=>$post->id
        ]);
        $this->assertCount(1, Comment::all());
        $this->assertCount(1, $post->comments);
        $this->assertEquals(1, $post->refresh()->comments_count);
    }

    /** @test */
    public function comment_validation() {
        $post = Post::factory()->create(['status'=>'published']);
        
        $this->post('/comments', ['content'=>'hello','post_id'=>-1])
            ->assertSessionHasErrors(['post_id']); // post_id does not exist
        $this->post('/comments', ['post_id'=>$post->id])
            ->assertSessionHasErrors(['content']); // content field is required
    }

    /** @test */
    public function comments_are_not_allowed_if_the_author_disables_comments() {
        $post = Post::factory()->create(['status'=>'published', 'allow_comments'=>0]);
        $this->post('/comments', ['content'=>'hello', 'post_id'=>$post->id])
            ->assertStatus(403);
    }

    /** @test */
    public function comments_are_not_allowed_for_unpublished_posts() {
        $post = Post::factory()->create(['status'=>'draft', 'allow_comments'=>0]);
        $this->post('/comments', ['content'=>'hello', 'post_id'=>$post->id])
            ->assertStatus(403);
    }

    /** @test */
    public function comments_are_not_allowed_for_private_posts() {
        $post = Post::factory()->create(['status'=>'published', 'visibility'=>'private']);
        $visitor = User::factory()->create();
        $this->actingAs($visitor);
        $this->post('/comments', ['content'=>'hello', 'post_id'=>$post->id])
            ->assertStatus(403);
    }

    /** @test */
    public function comments_limit() {
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $comments = Comment::factory(159)->create([
            'user_id'=>$user->id,
            'post_id'=>$post->id
        ]);
        $this->post('/comments', ['content'=>'hello', 'post_id'=>$post->id])
            ->assertOk();
        $this->post('/comments', ['content'=>'hello', 'post_id'=>$post->id])
            ->assertStatus(403);
    }
}
