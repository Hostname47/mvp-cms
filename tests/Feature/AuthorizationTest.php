<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\{User,Permission};


class AuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    protected $authuser;

    public function setUp(): void {
        parent::setUp();

        $user = $this->authuser = User::factory()->create();
        $this->actingAs($user);

        $permissions = [
            'access-admin-section' => Permission::factory()->create(['title'=>'aas', 'slug'=>'access-admin-section']),
            'change-post-status' => Permission::factory()->create(['title'=>'cps', 'slug'=>'change-post-status']),
        ];

        $user->attach_permission('access-admin-section');
    }

    /** @test */
    public function unauthorized_action_record_saved_if_anyone_implement_unauthorized_action() {
        $post = \App\Models\Post::factory()->create([
            'title' => 'cool title',
            'title_meta' => 'cool-title',
            'slug' => 'cool title',
            'summary' => 'hello world',
            'content' => 'hello world',
        ]);
        $user = $this->authuser;
        $user->detach_permission('change-post-status');

        $this->assertCount(0, $user->authorization_breaks);
        $this->patch('/admin/posts/status', [
            'post_id'=>$post->id,
            'status'=>'published'
        ])->assertForbidden();
        $this->assertCount(1, $user->refresh()->authorization_breaks);
    }
}
