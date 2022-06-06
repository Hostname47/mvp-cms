<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\{Faq,User,Permission};

class FaqTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

    public function setUp():void {
        parent::setUp();
        
        $permissions = [
            'access-admin-section' => Permission::factory()->create(['title'=>'aas', 'slug'=>'access-admin-section']),
            'update-faq-priority' => Permission::factory()->create(['title'=>'ufp', 'slug'=>'update-faq-priority']),
        ];

        $user = $this->authuser = User::factory()->create();
        $this->actingAs($user);

        $user->attach_permission('access-admin-section');
        $user->attach_permission('update-faq-priority');
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
        $this->post('/faqs', ['question'=>'how to do something', 'description'=>Str::random(1001)])
            ->assertSessionHasErrors(['description']);
        $this->post('/faqs', ['question'=>Str::random(500), 'description'=>Str::random(1000)])->assertOk();
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

    /** Admin section */

    /** @test */
    public function update_faqs_priorities() {
        $this->withoutExceptionHandling();
        $faq0 = Faq::factory()->create(['user_id'=>$this->authuser->id, 'priority'=>1]);
        $faq1 = Faq::factory()->create(['user_id'=>$this->authuser->id, 'priority'=>2]);

        $this->assertEquals(1, $faq0->priority);
        $this->assertEquals(2, $faq1->priority);
        $this->post('/admin/faqs/priorities', [
            'faqs'=>[$faq0->id, $faq1->id],
            'priorities'=>[2, 1],
        ]);
        $this->assertEquals(2, $faq0->refresh()->priority);
        $this->assertEquals(1, $faq1->refresh()->priority);
    }
}
