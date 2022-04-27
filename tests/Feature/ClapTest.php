<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,Post,Comment,Clap};

class ClapTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

    public function setUp():void {
        parent::setUp();
        
        $this->authuser = $authuser = User::factory()->create();
        $this->actingAs($authuser);
    }

    /** @test */
    public function clap_a_comment() {
        $this->withoutExceptionHandling();
        $user = $this->authuser;
        $post = Post::factory()->create(['status'=>'published']);
        $comment = Comment::factory()->create(['user_id'=>$user->id,'post_id'=>$post->id]);

        $this->assertCount(0, Clap::all());
        $this->post('/claps', [
            'clapable_id'=>$comment->id,
            'clapable_type'=>'comment'
        ]);
        $this->assertCount(1, Clap::all()); // Previous request clap the comment
        $this->post('/claps', [
            'clapable_id'=>$comment->id,
            'clapable_type'=>'comment'
        ]);
        $this->assertCount(0, Clap::all()); // Previous request unclap the comment
    }
}
