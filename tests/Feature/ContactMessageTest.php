<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,ContactMessage};

class ContactMessageTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

    public function setUp():void {
        parent::setUp();
        
        $this->authuser = $authuser = User::factory()->create();
        $this->actingAs($authuser);
    }

    /** @test */
    public function send_a_contact_message() {
        $user = $this->authuser;

        $this->assertCount(0, ContactMessage::all());
        $this->post('/contact', [
            'firstname'=>'mouad',
            'lastname'=>'nassri',
            'email'=>'hello@none.com',
            'message'=>'hello darkness'
        ]);
        $this->assertCount(1, ContactMessage::all());
        $message = ContactMessage::first();
        $this->assertTrue(!is_null($message->user_id));
    }

    /** @test */
    public function guest_user_send_contact_message() {
        $this->post('/logout');

        $this->assertCount(0, ContactMessage::all());
        $this->post('/contact', [
            'firstname'=>'mouad',
            'lastname'=>'nassri',
            'email'=>'hello@none.com',
            'message'=>'hello darkness'
        ]);
        $this->assertCount(1, ContactMessage::all());
        $this->assertTrue(is_null(ContactMessage::first()->user_id));
    }

    /** @test */
    public function send_contact_message_validation() {
        // For authenticated users : only message is required
        $this->post('/contact')->assertSessionHasErrors(['message']);
        $this->post('/contact', ['message'=>'helo'])->assertOk();
        
        $this->post('/logout');

        // For guest users, all fields are required
        $this->post('/contact')->assertSessionHasErrors(['firstname','lastname','email','message']);
        $this->post('/contact', ['firstname'=>'a','lastname'=>'a','email'=>'invalide-email@','message'=>'hello'])
            ->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function contact_messages_are_limited_per_day() {
        $user = $this->authuser;
        $messages = ContactMessage::factory(10)->create(['user_id'=>$user->id]);
        $this->post('/contact', ['firstname'=>'a','lastname'=>'a','email'=>'a@a.com','message'=>'hello'])
            ->assertForbidden();
    }

    /** @test */
    public function contact_messages_are_limited_per_day_for_guests() {
        $this->post('/logout');

        $user = $this->authuser;
        $messages = ContactMessage::factory(10)->create(['ip'=>'192.168.1.1']);
        $this->post('/contact',
            ['firstname'=>'a','lastname'=>'a','email'=>'a@a.com','message'=>'hello'],
            ['REMOTE_ADDR' => '192.168.1.1']
        )->assertForbidden();
    }

    /** @test */
    // public function contact_messages_are_limited_per_day_globally() {
    //     $messages = ContactMessage::factory(4999)->create();
    //     $this->post('/contact', [
    //         'message'=>'hello darkness'
    //     ])->assertOk();

    //     $this->post('/contact', [
    //         'message'=>'hello darkness'
    //     ])->assertForbidden();
    // }
}
