<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
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
        $this->withoutExceptionHandling();
        $this->assertCount(0, Faq::all());
        $this->post('/faqs', ['question'=>'hello darkness ?', 'description'=>'hola amigos']);
        $this->assertCount(1, Faq::all());
    }
}
