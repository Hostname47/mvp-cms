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
        $this->withoutExceptionHandling();
        $post = Post::factory()->create(['status'=>'published']);
        
        $this->assertCount(0, Comment::all());
        $this->post('/comments', [
            'content'=>'hello darkness my old friend',
            'post_id'=>$post->id
        ]);
        $this->assertCount(1, Comment::all());
    }
}
