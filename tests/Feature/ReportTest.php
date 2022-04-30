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
        $this->withoutExceptionHandling();
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
}
