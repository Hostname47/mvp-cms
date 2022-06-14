<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,AuthorRequest,Category,Role,Permission,Post};

class AuthorTest extends TestCase
{
    use DatabaseTransactions;

    protected $authuser;

    public function setUp(): void {
        parent::setUp();

        $permissions = [
            'access-admin-section' => Permission::factory()->create(['title'=>'aas', 'slug'=>'access-admin-section']),
            'accept-author-request' => Permission::factory()->create(['title'=>'aar', 'slug'=>'accept-author-request']),
            'refuse-author-request' => Permission::factory()->create(['title'=>'rar', 'slug'=>'refuse-author-request']),
            'delete-author-request' => Permission::factory()->create(['title'=>'dar', 'slug'=>'delete-author-request']),
            'author-create-post' => Permission::factory()->create(['title'=>'acp', 'slug'=>'author-create-post']),
            'revoke-role' => Permission::factory()->create(['title'=>'rr', 'slug'=>'revoke-role']),
            'create-post' => Permission::factory()->create(['title'=>'cp', 'slug'=>'create-post']),
        ];

        $contributor_author = Role::create(['title'=>'Contributor author','slug'=>'contributor-author','description'=>'Contributor author']);
        $contributor_author->permissions()->attach($permissions['author-create-post']->id);

        $user = $this->authuser = User::factory()->create();
        $this->actingAs($user);
        $user->attach_permission('access-admin-section');
        $user->attach_permission('accept-author-request');
        $user->attach_permission('refuse-author-request');
        $user->attach_permission('delete-author-request');
        $user->attach_permission('revoke-role');
        $user->attach_permission('create-post');
    }

    /** @test */
    public function accept_author_request() {
        $user = User::factory()->create();
        $technology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);
        // Send a request
        $this->actingAs($user);
        $this->post('/author-request', [
            'categories'=>[$technology->id],
            'message'=>'I want to become a writer at fibonashi :)',
        ]);

        $this->actingAs($this->authuser);
        $request = AuthorRequest::first();

        $this->assertEquals(0, $user->elected_author);
        $this->assertFalse($user->has_permission('author-create-post'));
        $this->assertFalse($user->has_role('contributor-author'));
        $this->assertEquals(0, $request->status);

        $this->post('/admin/author/requests/accept', ['request'=>$request->id]);

        $user->refresh();
        $request->refresh();

        $this->assertEquals(1, $user->elected_author);
        $this->assertTrue($user->has_permission('author-create-post'));
        $this->assertTrue($user->has_role('contributor-author'));
        $this->assertEquals(1, $request->status);
    }

    /** @test */
    public function accept_author_request_requires_permission() {
        $user = User::factory()->create();
        $technology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);
        // Send a request
        $this->actingAs($user);
        $this->post('/author-request', [
            'categories'=>[$technology->id],
            'message'=>'I want to become a writer at fibonashi :)',
        ]);

        $this->actingAs($this->authuser);
        $this->authuser->detach_permission('accept-author-request');

        $this->post('/admin/author/requests/accept', ['request'=>AuthorRequest::first()->id])
            ->assertForbidden();
    }

    /** @test */
    public function refuse_author_request() {
        $user = User::factory()->create();
        $technology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);
        // Send a request
        $this->actingAs($user);
        $this->post('/author-request', [
            'categories'=>[$technology->id],
            'message'=>'I want to become a writer at fibonashi :)',
        ]);

        $this->actingAs($this->authuser);
        $request = AuthorRequest::first();

        $this->assertEquals(0, $request->status);
        $this->post('/admin/author/requests/refuse', ['request'=>$request->id]);
        $this->assertEquals(-1, $request->refresh()->status);
    }

    /** @test */
    public function refuse_author_request_requires_permission() {
        $user = User::factory()->create();
        $technology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);
        // Send a request
        $this->actingAs($user);
        $this->post('/author-request', [
            'categories'=>[$technology->id],
            'message'=>'I want to become a writer at fibonashi :)',
        ]);

        $this->actingAs($this->authuser);
        $request = AuthorRequest::first();
        $this->authuser->detach_permission('refuse-author-request');
        $this->post('/admin/author/requests/refuse', ['request'=>$request->id])
            ->assertForbidden();
    }

    /** @test */
    public function delete_an_author_request() {
        $user = User::factory()->create();
        $technology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);
        // Send a request
        $this->actingAs($user);
        $this->post('/author-request', [
            'categories'=>[$technology->id],
            'message'=>'I want to become a writer at fibonashi :)',
        ]);

        $this->actingAs($this->authuser);

        $this->assertCount(1, AuthorRequest::all());
        $this->delete('/admin/author/requests', ['request'=>AuthorRequest::first()->id]);
        $this->assertCount(0, AuthorRequest::all());
    }

    /** @test */
    public function delete_an_author_request_requires_permission() {
        $user = User::factory()->create();
        $technology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);
        // Send a request
        $this->actingAs($user);
        $this->post('/author-request', [
            'categories'=>[$technology->id],
            'message'=>'I want to become a writer at fibonashi :)',
        ]);

        $this->actingAs($this->authuser);
        $this->authuser->detach_permission('delete-author-request');

        $this->delete('/admin/author/requests', ['request'=>AuthorRequest::first()->id])
            ->assertForbidden();
    }

    /** @test */
    public function revoke_contributor_author_role_from_a_contributor_author() {
        $user = User::factory()->create();
        $technology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);
        // Send a request
        $this->actingAs($user);
        $this->post('/author-request', [
            'categories'=>[$technology->id],
            'message'=>'I want to become a writer at fibonashi :)',
        ]);

        $this->actingAs($this->authuser);
        $request = AuthorRequest::first();

        $this->post('/admin/author/requests/accept', ['request'=>$request->id]);

        $user->refresh();
        $this->assertTrue($user->has_role('contributor-author'));
        $this->assertEquals(1, $user->elected_author);
        $this->assertCount(1, AuthorRequest::all());
        $this->post('/admin/author/revoke', ['user'=>$user->id]);
        $user->refresh();
        $this->assertFalse($user->has_role('contributor-author'));
        $this->assertEquals(0, $user->elected_author);
        $this->assertCount(0, AuthorRequest::all());
    }

    /** @test */
    public function revoke_contributor_author_role_requires_permission() {
        $user = User::factory()->create();
        $technology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);
        // Send a request
        $this->actingAs($user);
        $this->post('/author-request', [
            'categories'=>[$technology->id],
            'message'=>'I want to become a writer at fibonashi :)',
        ]);
        $this->actingAs($this->authuser);
        $request = AuthorRequest::first();
        $this->post('/admin/author/requests/accept', ['request'=>$request->id]);

        $this->authuser->detach_permission('revoke-role');
        $this->post('/admin/author/revoke', ['user'=>$user->id])
            ->assertForbidden();
    }

    /** @test */
    public function revoke_contributor_author_role_and_delete_posts() {
        $user = User::factory()->create();
        $technology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);
        $uncategorized = Category::factory()->create(['title'=>'Uncategorized','slug'=>'uncategorized','status'=>'live']);
        // Send a request
        $this->actingAs($user);
        $this->post('/author-request', [
            'categories'=>[$technology->id],
            'message'=>'I want to become a writer at fibonashi :)',
        ]);

        $this->actingAs($this->authuser);
        $request = AuthorRequest::first();

        $this->post('/admin/author/requests/accept', ['request'=>$request->id]);

        $post = Post::factory()->create(['title'=>'foo','title_meta'=>'foo','slug'=>'foo','summary'=>'foo','content'=>'foo','user_id'=>$user->id]);
        $post->categories()->attach($uncategorized->id);

        $this->assertCount(1, Post::all());
        $this->post('/admin/author/revoke', ['user'=>$user->id, 'author_resources_action'=>'delete']);
        $this->assertCount(0, Post::all());
    }
}
