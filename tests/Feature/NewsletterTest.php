<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{Subscriber,User};

class NewsletterTest extends TestCase
{
    use DatabaseTransactions;
    
    /** @test */
    public function a_guest_user_subscribe_to_newsletter() {
        $this->assertCount(0, Subscriber::all());
        $this->post('/newsletter/subscribe', [
            'email'=>'mouad@gmail.com',
            'name'=>'mouad nassri'
        ]);
        $this->assertCount(1, Subscriber::all());
        $subscriber = Subscriber::first();
        $this->assertEquals('mouad nassri', $subscriber->name);
        $this->assertEquals('mouad@gmail.com', $subscriber->email);
        $this->assertEquals(null, $subscriber->user_id);
    }

    /** @test */
    public function an_auth_user_subscribe_to_newsletter() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertCount(0, Subscriber::all());
        $this->post('/newsletter/subscribe', [
            'email'=>'mouad@gmail.com',
            'name'=>'mouad nassri'
        ]);
        $this->assertCount(1, Subscriber::all());
        $this->assertEquals($user->id, Subscriber::first()->user_id);
    }

    /** @test */
    public function newsletter_email_should_be_unique() {
        $subscriber = Subscriber::create(['name'=>'mouad nassri','email'=>'mouad@gmail.com']);
        $this->post('/newsletter/subscribe', [
            'name'=>'mouad nassri',
            'email'=>'mouad@gmail.com',
        ])->assertRedirect()->assertSessionHasErrors(['email']);
        $this->post('/newsletter/subscribe', [
            'name'=>'mouad nassri',
            'email'=>'other-visitor@gmail.com',
        ])->assertOk();
    }

    /** @test */
    public function newsletter_subscription_guest_authorization() {
        $emails = ['a@a.com','b@a.com','c@a.com','d@a.com','e@a.com','f@a.com','g@a.com','h@a.com','i@a.com', 'j@a.com'];
        foreach($emails as $email) {
            $this->post('/newsletter/subscribe', [
                'name'=>'mouad nassri',
                'email'=>$email,
            ]);
        }
        
        $this->post('/newsletter/subscribe', [
            'name'=>'mouad nassri',
            'email'=>'new@gmail.com',
        ])->assertStatus(403);
    }

    /** @test */
    public function newsletter_subscription_auth_authorization() {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $this->post('/newsletter/subscribe', [
            'name'=>'mouad nassri',
            'email'=>'mouad@gmail.com',
        ])->assertOk();
        
        $this->post('/newsletter/subscribe', [
            'name'=>'mouad nassri',
            'email'=>'other@gmail.com', // Even if the email is different the auth user already a subscriber => 403
        ])->assertStatus(403);
    }
}