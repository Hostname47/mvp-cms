<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
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
        $this->actingAs($user);
        $category = Category::factory()->create();

        $this->assertCount(0, Post::all());
        $this->post('/admin/posts', [
            'title' => 'cool title',
            'title_meta' => 'cool-title',
            'slug' => 'cool title',
            'summary' => 'hello world',
            'content' => 'hello world',
            'user_id' => $user->id,
            'categories'=>[$category->id]
        ]);
        $this->assertCount(1, Post::all());
        $post = Post::first();
        $this->assertCount(1, $post->categories);
    }

    /** @test */
    public function post_creation_data_validation() {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create();

        $response = $this->post('/admin/posts');
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'title_meta', 'slug', 'summary', 'content']);
        $response = $this->post('/admin/posts', ['title'=>'awesome title']);
        $response->assertSessionHasErrors(['title_meta', 'slug', 'summary', 'content']);
        $response = $this->post('/admin/posts', ['title'=>'awesome title']);
        $response->assertSessionHasErrors(['title_meta', 'slug', 'summary', 'content']);
        $response = $this->post('/admin/posts', [
            'title' => 'cool title', 'title_meta' => 'cool-title', 'slug' => 'cool title', 'summary' => 'hello world', 'content' => 'hello world', 'user_id' => $user->id, 'categories'=>[$category->id],
            'status'=> 'invalid-status', 'visibility'=>'invalid-visibility'
        ]);
        $response->assertSessionHasErrors(['status', 'visibility']);
    }

    /** @test */
    public function post_can_belong_to_multiple_categories() {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $this->post('/admin/posts', [
            'title' => 'cool title',
            'title_meta' => 'cool-title',
            'slug' => 'cool title',
            'summary' => 'hello world',
            'content' => 'hello world',
            'user_id' => $user->id,
            'categories'=>[$category1->id, $category2->id]
        ]);
        $post = Post::first();
        $this->assertCount(2, $post->categories);
    }

    /** @test */
    public function set_post_featured_image() {

    }
}
