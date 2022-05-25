<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,Post,Comment,Permission};

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

    public function setUp():void {
        parent::setUp();
        
        $permissions = [
            'access-admin-section' => Permission::factory()->create(['title'=>'aas', 'slug'=>'access-admin-section']),
            'create-post' => Permission::factory()->create(['title'=>'cp', 'slug'=>'create-post']),
            'trash-comment' => Permission::factory()->create(['title'=>'tc', 'slug'=>'trash-comment']),
            'untrash-comment' => Permission::factory()->create(['title'=>'utc', 'slug'=>'untrash-comment']),
            'restore-comment' => Permission::factory()->create(['title'=>'rc', 'slug'=>'restore-comment']),
        ];

        $user = $this->authuser = User::factory()->create();
        $this->actingAs($user);
        $user->attach_permission('access-admin-section');
        $user->attach_permission('trash-comment');
        $user->attach_permission('untrash-comment');
        $user->attach_permission('restore-comment');
    }

    // ========== Admin ==========

    /** @test */
    public function trash_a_comment() {
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::factory()->create([
            'user_id'=>$user->id,
            'post_id'=>$post->id
        ]);

        $this->assertNull($comment->deleted_at);
        $this->post('/admin/comments/trash', [
            'comment_id'=>$comment->id
        ]);
        $this->assertNotNull($comment->refresh()->deleted_at);
    }

    /** @test */
    public function trash_comment_require_permission() {
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::factory()->create([
            'user_id'=>$user->id,
            'post_id'=>$post->id
        ]);

        $user->detach_permission('trash-comment');

        $this->post('/admin/comments/trash', [
            'comment_id'=>$comment->id
        ])->assertForbidden();
    }

    /** @test */
    public function untrash_a_comment() {
        $this->withoutExceptionHandling();
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::factory()->create(['user_id'=>$user->id,'post_id'=>$post->id]);

        $this->post('/admin/comments/trash', [
            'comment_id'=>$comment->id
        ]);
        $this->assertEquals('trashed', $comment->refresh()->status);
        $this->post('/admin/comments/untrash', [
            'comment_id'=>$comment->id
        ]);
        $this->assertEquals('pending', $comment->refresh()->status);
    }

    /** @test */
    public function untrash_comment_require_permission() {
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::factory()->create(['user_id'=>$user->id, 'post_id'=>$post->id]);

        $user->detach_permission('untrash-comment');

        $this->post('/admin/comments/untrash', [
            'comment_id'=>$comment->id
        ])->assertForbidden();
    }

    /** @test */
    public function restore_a_comment() {
        $this->withoutExceptionHandling();
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::factory()->create(['user_id'=>$user->id,'post_id'=>$post->id]);

        $this->post('/admin/comments/trash', [
            'comment_id'=>$comment->id
        ]);
        $this->assertEquals('trashed', $comment->refresh()->status);
        $this->post('/admin/comments/restore', [
            'comment_id'=>$comment->id
        ]);
        $this->assertEquals('published', $comment->refresh()->status);
    }

    /** @test */
    public function restore_comment_require_permission() {
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::factory()->create(['user_id'=>$user->id,'post_id'=>$post->id]);

        $this->post('/admin/comments/trash', [
            'comment_id'=>$comment->id
        ]);
        $this->assertEquals('trashed', $comment->refresh()->status);
        $user->detach_permission('restore-comment');
        $this->post('/admin/comments/restore', [
            'comment_id'=>$comment->id
        ])->assertForbidden();
    }

    // ===========================

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
        ])->assertForbidden(); // $user cannot update $other's comment
        
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
    public function comment_can_be_deleted_by_its_owner_only() {
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
        ])->assertForbidden();
        
        $this->actingAs($author);
        $this->delete('/comments', [
            'comment_id'=>$comment->id,
        ])->assertForbidden();

        $this->actingAs($commenter);
        $this->assertCount(1, Comment::all());
        $this->delete('/comments', [
            'comment_id'=>$comment->id,
        ])->assertOk();
        $this->assertCount(0, Comment::all());
    }

    /** @test */
    public function delete_a_comment_will_delete_all_its_subcomments() {
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $c0 = Comment::create(['content'=>'hello world','user_id'=>$user->id,'post_id'=>$post->id]);
        // Following 2 are direct replies to c0
        $c00 = Comment::create(['content'=>'c00','user_id'=>$user->id,'post_id'=>$post->id, 'parent_comment_id'=>$c0->id]);
        $c01 = Comment::create(['content'=>'c01','user_id'=>$user->id,'post_id'=>$post->id, 'parent_comment_id'=>$c0->id]);
        // Following is reply to c00
        $c000 = Comment::create(['content'=>'c000','user_id'=>$user->id,'post_id'=>$post->id, 'parent_comment_id'=>$c00->id]);

        $this->assertCount(4, Comment::all());
        $this->delete('/comments', ['comment_id'=>$c0->id]);
        $this->assertCount(0, Comment::all());
    }

    /** @test */
    public function comment_post_comments_count_is_reduced_once_comment_get_deleted() {
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $this->post('/comments', ['content'=>'c0','post_id'=>$post->id]);
        $this->post('/comments', ['content'=>'c1','post_id'=>$post->id]);
        $c0 = Comment::where('content', 'c0')->first();
        $this->post('/comments', ['content'=>'c00','post_id'=>$post->id,'parent_comment_id'=>$c0->id]);
        $this->post('/comments', ['content'=>'c01','post_id'=>$post->id,'parent_comment_id'=>$c0->id]);

        $this->assertEquals(4, $post->refresh()->comments_count);
        $this->delete('/comments', ['comment_id'=>$c0->id]);
        /**
         * After deleting c0, all its subcommments will get deleted as well; c1 stay there
         */
        $this->assertEquals(1, $post->refresh()->comments_count);
    }
}
