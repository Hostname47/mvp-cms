<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\{Faq,User};

class FaqTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

    public function setUp():void {
        parent::setUp();
        
        $this->authuser = $authuser = User::factory()->create();
        $this->actingAs($authuser);
    }

    /** @test */
    public function submit_faq() {
        $this->assertCount(0, Faq::all());
        $this->post('/faqs', ['question'=>'hello darkness ?', 'description'=>'hola amigos']);
        $this->assertCount(1, Faq::all());
    }
    
    /** @test */
    public function submit_faq_validation() {
        $this->post('/faqs')->assertSessionHasErrors(['question']); // question is required
        $this->post('/faqs', ['question'=>Str::random(501)])->assertSessionHasErrors(['question']); // question is too long
        $this->post('/faqs', ['question'=>'how to do something', 'description'=>Str::random(2001)])
            ->assertSessionHasErrors(['description']);
        $this->post('/faqs', ['question'=>Str::random(500), 'description'=>Str::random(2000)])->assertOk();
    }

    /** @test */
    public function guest_users_cannot_submit_faqs() {
        $this->post('/logout');
        $this->post('/faqs', ['question'=>'hello darkness ?', 'description'=>'hola amigos'])->assertForbidden();
    }

    /** @test */
    public function faqs_are_day_limited() {
        $user = $this->authuser;
        $faqs = Faq::factory(6)->create(['user_id'=>$user->id]);
        $this->post('/faqs', ['question'=>'hello darkness ?', 'description'=>'hola amigos'])
            ->assertForbidden(); // User faqs per day limit reached
    }
}
