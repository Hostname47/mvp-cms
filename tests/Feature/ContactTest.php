<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,ContactMessage};

class ContactTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

    public function setUp():void {
        parent::setUp();
        
        $this->authuser = $authuser = User::factory()->create();
        $this->actingAs($authuser);
    }

    /** @test */
    public function send_a_contact_message()
    {
        $this->withoutExceptionHandling();
        $user = $this->authuser;

        $this->assertCount(0, ContactMessage::all());
        $this->post('/contact', [
            'firstname'=>'mouad',
            'lastname'=>'nassri',
            'email'=>'hello@none.com',
            'message'=>'hello darkness'
        ]);
        $this->assertCount(1, ContactMessage::all());
    }
}
