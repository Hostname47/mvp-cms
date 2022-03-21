<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User, Category, Post};

class PostTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        /** Some common resources between tests */
    }

    /** @test */
    public function creating_a_post() {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($user);

        $this->assertCount(0, Post::all());
        $this->post('/posts', [
            'title' => 'cool title',
            'title_meta' => 'cool-title',
            'slug' => 'cool title',
            'content' => 'hello world',
            'user_id' => $user->id,
            'category_id' => $category->id
        ]);
        $this->assertCount(1, Post::all());
    }

    /** @test */
    public function updating_a_post() {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($user);

        Post::create([
            'title' => 'cool title',
            'title_meta' => 'cool-title',
            'slug' => 'cool title',
            'content' => 'hello world',
            'user_id' => $user->id,
            'category_id' => $category->id
        ]);
        $post = Post::first();

        $this->assertEquals('cool title', $post->title);
        $this->patch('/posts', [
            'post_id' => $post->id,
            'title'=>'nice title'
        ]);
        $this->assertEquals('nice title', $post->refresh()->title);
    }
}
