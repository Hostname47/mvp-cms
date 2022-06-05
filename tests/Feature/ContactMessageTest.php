<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,ContactMessage,Permission};

class ContactMessageTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

    public function setUp():void {
        parent::setUp();
        
        $permissions = [
            'access-admin-section' => Permission::factory()->create(['title'=>'aas', 'slug'=>'access-admin-section']),
            'read-contact-message' => Permission::factory()->create(['title'=>'rcm', 'slug'=>'read-contact-message']),
        ];

        $user = $this->authuser = User::factory()->create();
        $this->actingAs($user);

        $user->attach_permission('access-admin-section');
        $user->attach_permission('read-contact-message');
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
        $this->post('/contact', ['message'=>'hello worls !'])->assertOk();
        
        $this->post('/logout');

        // For guest users, all fields are required
        $this->post('/contact')->assertSessionHasErrors(['firstname','lastname','email','message']);
        $this->post('/contact', ['firstname'=>'a','lastname'=>'a','email'=>'invalide-email@','message'=>'hello'])
            ->assertSessionHasErrors(['message']); // Message should contains more than 10 characters
        $this->post('/contact', ['firstname'=>'a','lastname'=>'a','email'=>'invalide-email@','message'=>'hello world !'])
            ->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function contact_messages_are_limited_per_day() {
        $user = $this->authuser;
        $messages = ContactMessage::factory(10)->create(['user_id'=>$user->id]);
        $this->post('/contact', ['firstname'=>'a','lastname'=>'a','email'=>'a@a.com','message'=>'hello world !'])
            ->assertForbidden();
    }

    /** @test */
    public function contact_messages_are_limited_per_day_for_guests() {
        $this->post('/logout');

        $user = $this->authuser;
        $messages = ContactMessage::factory(10)->create(['ip'=>'192.168.1.1']);
        $this->post('/contact',
            ['firstname'=>'a','lastname'=>'a','email'=>'a@a.com','message'=>'hello world !'],
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

    /**
     * Admin section
     */

    /** @test */
    public function review_message() {
        $user = User::factory()->create();
        $message = ContactMessage::factory()->create(['user_id'=>$user->id]);

        $this->assertFalse((bool)$message->refresh()->read);
        $this->post('/admin/contact-messages/read', [
            'messages'=>[$message->id],
            'read'=>1
        ]);
        $this->assertTrue((bool)$message->refresh()->read);
        $this->post('/admin/contact-messages/read', [
            'messages'=>[$message->id],
            'read'=>0
        ]);
        $this->assertFalse((bool)$message->refresh()->reviewed);
    }
    
    /** @test */
    public function review_message_requires_permission() {
        $user = User::factory()->create();
        $message = ContactMessage::factory()->create(['user_id'=>$user->id]);

        $this->authuser->detach_permission('read-contact-message');
        $this->post('/admin/contact-messages/read', [
            'messages'=>[$message->id],
            'read'=>1
        ])->assertForbidden();
    }
}
