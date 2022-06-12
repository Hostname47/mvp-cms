<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,AuthorRequest,Category,Role,Permission};

class AuthorRequestTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

    public function setUp():void {
        parent::setUp();
        
        $permissions = [
            'access-admin-section' => Permission::factory()->create(['title'=>'aas', 'slug'=>'access-admin-section']),
            'accept-author-request' => Permission::factory()->create(['title'=>'aar', 'slug'=>'accept-author-request']),
            'refuse-author-request' => Permission::factory()->create(['title'=>'rar', 'slug'=>'refuse-author-request']),
            'delete-author-request' => Permission::factory()->create(['title'=>'dar', 'slug'=>'delete-author-request']),
            'author-create-post' => Permission::factory()->create(['title'=>'acp', 'slug'=>'author-create-post']),
        ];

        $user = $this->authuser = User::factory()->create();
        $this->actingAs($user);

        $user->attach_permission('access-admin-section');
        $user->attach_permission('accept-author-request');
        $user->attach_permission('refuse-author-request');
        $user->attach_permission('delete-author-request');
    }

    /** @test */
    public function author_request() {
        $user = $this->authuser;
        $this->actingAs($user);

        $tecnology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);
        $traveling = Category::create(['title'=>'traveling','title_meta'=>'traveling','slug'=>'traveling','description'=>'traveling']);

        $this->assertCount(0, AuthorRequest::all());
        $this->post('/author-request', [
            'categories'=>[$tecnology->id,$traveling->id],
            'message'=>'I want to become a writer at fibonashi :)',
        ]);
        $this->assertCount(1, AuthorRequest::all());
    }

    /** @test */
    public function author_request_validation() {
        $user = $this->authuser;
        $this->actingAs($user);

        $this->post('/author-request', [
            'categories'=>[-98],
        ])->assertSessionHasErrors(['categories.*','message']); // Category does not exists && message required
    }

    /** @test */
    public function only_authenticated_users_can_sent_request() {
        $this->post('/logout');
        $tecnology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);
        $this->post('/author-request', [
            'categories'=>[$tecnology->id],
            'message'=>'hello world !'
        ])->assertForbidden();
    }

    /** @test */
    public function sent_author_request_twice_is_not_allowed() {
        $user = $this->authuser;
        $this->actingAs($user);

        $tecnology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);

        $this->post('/author-request', [
            'categories'=>[$tecnology->id],
            'message'=>'I want to become a writer at fibonashi :)',
        ])->assertOk();

        $this->post('/author-request', [
            'categories'=>[$tecnology->id],
            'message'=>'I want to become a writer at fibonashi :)',
        ])->assertForbidden();
    }

    /** @test */
    // public function users_with_author_role_could_not_sent_request_again() {
    //     $user = $this->authuser;
    //     $this->actingAs($user);
    //     $tecnology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);
    //     $author = Role::create(['title'=>'author','slug'=>'author','description'=>'--']);
    //     $user->roles()->attach($author->id);

    //     $this->post('/author-request', [
    //         'categories'=>[$tecnology->id],
    //         'message'=>'I want to become a writer at fibonashi :)',
    //     ])->assertForbidden();
    // }

    /**
     * Admin section
     */

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
        $this->assertEquals(0, $request->status);

        $this->post('/admin/author/requests/accept', ['request'=>$request->id]);

        $user->refresh();
        $request->refresh();

        $this->assertEquals(1, $user->elected_author);
        $this->assertTrue($user->has_permission('author-create-post'));
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
}
