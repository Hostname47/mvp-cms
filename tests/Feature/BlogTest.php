<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User, Category, Blog};

class BlogTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp() : void {
        parent::setUp();

        /** Some common resources between tests */
    }

    /** @test */
    public function creating_a_blog() {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->assertCount(0, Blog::all());
        $this->post('/blogs', [
            'title'=>'cool title',
            'meta_title'=>'cool-title',
            'slug'=>'cool title',
            'content'=>'hello world',
            'user_id'=>$user->id,
            'category_id'=>$category->id
        ]);
        $this->assertCount(1, Blog::all());
    }
}
