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
    public function write_a_comment_on_a_post() {
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

    /** @test */
    public function unauthenticated_user_cannot_comment() {
        $this->post('/logout');
        $post = Post::factory()->create(['status'=>'published']);

        $this->post('/comments', [
            'content'=>'hello darkness my old friend',
            'post_id'=>$post->id
        ])->assertRedirect();
    }

    /** @test */
    public function reply_to_a_comment() {
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::factory()->create([
            'user_id'=>$user->id,
            'post_id'=>$post->id
        ]);
        $this->assertCount(0, $comment->replies);
        $this->assertEquals(0, $comment->replies_count);
        $this->post('/comments', [
            'content'=>'hello darkness my old friend',
            'post_id'=>$post->id,
            'parent_comment_id'=>$comment->id
        ]);
        $this->assertCount(1, $comment->refresh()->replies);
        $this->assertEquals(1, $comment->replies_count);
    }

    /** @test */
    public function update_a_comment() {
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::create([
            'content'=>'hello world',
            'user_id'=>$user->id,
            'post_id'=>$post->id
        ]);

        $this->assertEquals('hello world', $comment->content);
        $this->patch('/comments', [
            'comment_id'=>$comment->id,
            'content'=>'hello darkness my old friend',
        ]);
        $this->assertEquals('hello darkness my old friend', $comment->refresh()->content);
    }

    /** @test */
    public function update_a_post_validation() {
        $this->patch('/comments', ['comment_id'=>-1,'content'=>'hello'])
            ->assertSessionHasErrors(['comment_id']); // comment does not exist with id=-1
    }

    /** @test */
    public function only_comment_owner_can_update_it() {
        $user = $this->authuser;
        $other = User::factory()->create();
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::create([
            'content'=>'hello world',
            'user_id'=>$other->id,
            'post_id'=>$post->id
        ]);
        
        $this->patch('/comments', [
            'comment_id'=>$comment->id,
            'content'=>'hello darkness my old friend',
        ])->assertStatus(403); // $user cannot update $other's comment
        
        $this->actingAs($other);
        $this->patch('/comments', [
            'comment_id'=>$comment->id,
            'content'=>'hello darkness my old friend',
        ])->assertOk();
    }
    
    /** @test */
    public function unauthenticated_user_cannot_update_a_comment() {
        $this->post('/logout');
        $post = Post::factory()->create(['status'=>'published']);

        $this->patch('/comments', [
            'content'=>'hello darkness my old friend',
            'post_id'=>$post->id
        ])->assertRedirect();
    }

    /** @test */
    public function cannot_update_a_comment_of_a_post_not_available() {
        $user = $this->authuser;
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id'=>$other->id, 'status'=>'published', 'visibility'=>'private']);
        $comment = Comment::create([
            'content'=>'hello world',
            'user_id'=>$user->id,
            'post_id'=>$post->id
        ]);
        $this->patch('/comments', ['comment_id'=>$comment->id,'content'=>'hello'])
            ->assertStatus(404);
    }

    /** @test */
    public function delete_a_comment() {
        $this->withoutExceptionHandling();
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::create([
            'content'=>'hello world',
            'user_id'=>$user->id,
            'post_id'=>$post->id
        ]);

        $this->assertCount(1, Comment::all());
        $this->delete('/comments', ['comment_id'=>$comment->id]);
        $this->assertCount(0, Comment::all());
    }

    /** @test */
    public function delete_a_post_validation() {
        $this->delete('/comments', ['comment_id'=>-1])
            ->assertSessionHasErrors(['comment_id']);
    }

    /** @test */
    public function only_comment_owner_and_author_can_delete_it() {
        $author = $this->authuser;
        $commenter = User::factory()->create();
        $third = User::factory()->create();
        $post = Post::factory()->create(['status'=>'published', 'user_id'=>$author->id]);
        $comment = Comment::create([
            'content'=>'hello world',
            'user_id'=>$commenter->id,
            'post_id'=>$post->id
        ]);
        
        $this->actingAs($third);
        $this->delete('/comments', [
            'comment_id'=>$comment->id,
        ])->assertStatus(403);
        
        $this->actingAs($author);
        $this->assertCount(1, Comment::all());
        $this->delete('/comments', [
            'comment_id'=>$comment->id,
        ])->assertOk();
        $this->assertCount(0, Comment::all());
        
        $comment = Comment::create([
            'content'=>'hello world',
            'user_id'=>$commenter->id,
            'post_id'=>$post->id
        ]);

        $this->actingAs($commenter);
        $this->assertCount(1, Comment::all());
        $this->delete('/comments', [
            'comment_id'=>$comment->id,
        ])->assertOk();
        $this->assertCount(0, Comment::all());
    }
}
