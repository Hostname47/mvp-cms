<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,Post,Comment,Report,Category,Permission};

class ReportTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

    public function setUp():void {
        parent::setUp();
        
        $permissions = [
            'access-admin-section' => Permission::factory()->create(['title'=>'aas', 'slug'=>'access-admin-section']),
            'review-report' => Permission::factory()->create(['title'=>'rr', 'slug'=>'review-report']),
            'delete-report' => Permission::factory()->create(['title'=>'dr', 'slug'=>'delete-report']),
        ];

        $user = $this->authuser = User::factory()->create();
        $this->actingAs($user);

        $user->attach_permission('access-admin-section');
        $user->attach_permission('review-report');
        $user->attach_permission('delete-report');
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
        $post->categories()->attach(Category::factory()->create(['slug'=>'uncategorized']));

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

    /**
     * Admin section
     */

    /** @test */
    public function review_reports() {
        $commenter = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::create(['content'=>'hello world','user_id'=>$commenter->id,'post_id'=>$post->id]);

        $this->post('/reports', ['reportable_id'=>$comment->id,'reportable_type'=>'comment','type'=>'spam']);

        $report = Report::first();
        $this->assertFalse((bool)$report->reviewed);
        $this->post('/admin/reports/review', [
            'reports'=>[$report->id],
            'state'=>1 // true : reviewed, false : not reviewed
        ]);
        $this->assertTrue((bool)$report->refresh()->reviewed);
        $this->post('/admin/reports/review', [
            'reports'=>[$report->id],
            'state'=>0
        ]);
        $this->assertFalse((bool)$report->refresh()->reviewed);
    }

    /** @test */
    public function review_reports_requires_permission() {
        $commenter = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::create(['content'=>'hello world','user_id'=>$commenter->id,'post_id'=>$post->id]);
        
        $this->post('/reports', ['reportable_id'=>$comment->id,'reportable_type'=>'comment','type'=>'spam']);

        $this->authuser->detach_permission('review-report');
        $report = Report::first();
        $this->post('/admin/reports/review', [
            'reports'=>[$report->id],
            'state'=>1
        ])->assertForbidden();
    }

    /** @test */
    public function delete_reports() {
        $commenter = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::create(['content'=>'hello world','user_id'=>$commenter->id,'post_id'=>$post->id]);
        $this->post('/reports', ['reportable_id'=>$comment->id,'reportable_type'=>'comment','type'=>'spam']);

        $this->assertCount(1, Report::all());
        $this->delete('/admin/reports', [
            'reports'=>[Report::first()->id]
        ]);
        $this->assertCount(0, Report::all());
    }
    
    /** @test */
    public function delete_reports_requires_permission() {
        $commenter = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::create(['content'=>'hello world','user_id'=>$commenter->id,'post_id'=>$post->id]);
        $this->post('/reports', ['reportable_id'=>$comment->id,'reportable_type'=>'comment','type'=>'spam']);

        $this->authuser->detach_permission('delete-report');
        
        $this->delete('/admin/reports', [
            'reports'=>[Report::first()->id]
        ])->assertForbidden();
    }
}
