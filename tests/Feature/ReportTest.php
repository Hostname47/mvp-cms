<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,Post,Comment,Report};

class ReportTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

    public function setUp():void {
        parent::setUp();
        
        $this->authuser = $authuser = User::factory()->create();
        $this->actingAs($authuser);
    }

    /** @test */
    public function report_a_comment() {
        $user = $this->authuser;
        $commenter = User::factory()->create();
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::create([
            'content'=>'hello world',
            'user_id'=>$commenter->id,
            'post_id'=>$post->id
        ]);

        $this->assertCount(0, Report::all());
        $this->post('/reports', [
            'reportable_id'=>$comment->id,
            'reportable_type'=>'comment',
            'type'=>'spam',
        ]);
        $this->assertCount(1, Report::all());
        $this->assertCount(1, $comment->refresh()->reports);
    }

    /** @test */
    public function report_a_post() {
        $user = $this->authuser;
        $author = User::factory()->create();
        $post = Post::factory()->create(['status'=>'published']);

        $this->assertCount(0, $post->reports);
        $this->post('/reports', [
            'reportable_id'=>$post->id,
            'reportable_type'=>'post',
            'type'=>'spam',
        ]);
        $this->assertCount(1, $post->refresh()->reports);
    }

    /** @test */
    public function report_validation() {
        $user = $this->authuser;
        $commenter = User::factory()->create();
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::create([
            'content'=>'hello world',
            'user_id'=>$commenter->id,
            'post_id'=>$post->id
        ]);

        $this->post('/reports', ['reportable_id'=>$comment->id,'reportable_type'=>'tag','type'=>'spam'])
            ->assertSessionHasErrors(['reportable_type']);
        $this->post('/reports', ['reportable_id'=>$comment->id,'reportable_type'=>'comment','type'=>'sp=am'])
            ->assertSessionHasErrors(['type']);
        $this->post('/reports', ['reportable_id'=>$comment->id,'reportable_type'=>'comment','type'=>'moderator-intervention'])
            ->assertSessionHasErrors(['body']); // Body is required report needs moderators intervention
        $this->post('/reports', 
            ['reportable_id'=>$comment->id,'reportable_type'=>'comment','type'=>'moderator-intervention', 'body'=>'hello'])
            ->assertSessionHasErrors(['body']); // Body should have > 10 characters
        $this->post('/reports', 
            ['reportable_id'=>$comment->id,'reportable_type'=>'comment','type'=>'moderator-intervention', 'body'=>'hello world'])
            ->assertOk();
    }

    /** @test */
    public function report_a_none_available_resource_is_not_allowed() {
        $user = $this->authuser;
        $visitor = User::factory()->create();
        $post = Post::factory()->create(['status'=>'published', 'user_id'=>$user->id]);
        $this->post('/reports', 
            ['reportable_id'=>-1,'reportable_type'=>'post','type'=>'spam'])
            ->assertForbidden();
    }

    /** @test */
    public function user_cannot_report_his_own_resources() {
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published', 'user_id'=>$user->id]);
        $this->post('/reports', ['reportable_id'=>$post->id,'reportable_type'=>'post','type'=>'spam'])
            ->assertForbidden();
    }

    /** @test */
    public function user_can_report_a_resource_only_once() {
        $user = $this->authuser;
        $commenter = User::factory()->create();
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::create([
            'content'=>'hello world',
            'user_id'=>$commenter->id,
            'post_id'=>$post->id
        ]);

        $this->post('/reports', 
            ['reportable_id'=>$comment->id,'reportable_type'=>'comment','type'=>'spam'])
            ->assertOk();

        $this->post('/reports', 
            ['reportable_id'=>$comment->id,'reportable_type'=>'comment','type'=>'spam'])
            ->assertForbidden();
    }
}
