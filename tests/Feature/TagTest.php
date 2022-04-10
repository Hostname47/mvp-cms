<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,Tag};

class TagTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create_a_tag()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertCount(0, Tag::all());
        $this->post('/admin/tags', [
            'title'=>'Websockets',
            'title_meta'=>'Websockets',
            'slug'=>'websockets',
            'description'=>'websockets desc'
        ]);
        $this->assertCount(1, Tag::all());
    }
}
