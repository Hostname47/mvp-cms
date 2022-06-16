<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User};

class VisitTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

    public function setUp():void {
        parent::setUp();
        
        $this->authuser = $authuser = User::factory()->create();
        $this->actingAs($authuser);
    }

    public function tearDown():void {
        
        parent::tearDown();
    }

    /** @test */
    public function visit_a_page_will_be_recorded() {
        $user = $this->authuser;

        $this->assertCount(0, $user->visits);
        $this->get('/about');
        $this->assertCount(1, $user->refresh()->visits);
    }

    /** @test */
    public function visit_a_page_twice_will_increase_hits_column_in_visit_record() {
        $user = $this->authuser;

        $this->get('/about');
        $visit = $user->visits->first();
        $this->assertEquals(1, $visit->hits);
        $this->get('/about');
        $this->assertEquals(2, $visit->refresh()->hits);
    }
}
