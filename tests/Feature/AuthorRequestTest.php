<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,AuthorRequest,Category,Role};

class AuthorRequestTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

    public function setUp():void {
        parent::setUp();
        
        $this->authuser = $authuser = User::factory()->create();
        $this->actingAs($authuser);
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
    public function users_with_author_rile_could_not_sent_request_again() {
        $user = $this->authuser;
        $this->actingAs($user);
        $tecnology = Category::create(['title'=>'tech','title_meta'=>'tech','slug'=>'tech','description'=>'tech']);
        $author = Role::create(['title'=>'author','slug'=>'author','description'=>'--']);
        $user->roles()->attach($author->id);

        $this->post('/author-request', [
            'categories'=>[$tecnology->id],
            'message'=>'I want to become a writer at fibonashi :)',
        ])->assertForbidden();
    }
}
