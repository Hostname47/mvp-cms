<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function category_creation() {
        $this->assertCount(0, Category::all());
        $this->post('/categories', [
            'title'=>'cool category',
            'title_meta'=>'cool category',
            'slug'=>'cool-category',
            'description'=>'cool description'
        ]);
        $this->assertCount(1, Category::all());
    }

    /** @test */
    public function category_parent() {
        $this->withoutExceptionHandling();
        $parent = Category::create([
            'title'=>'cool category',
            'title_meta'=>'cool category',
            'slug'=>'cool-category',
            'description'=>'cool description'
        ]);

        $this->post('/categories', [
            'title'=>'awesome category',
            'title_meta'=>'awesome category',
            'slug'=>'awesome-category',
            'description'=>'awesome description',
            'parent_category_id'=>$parent->id
        ]);
        $this->assertCount(2, Category::all());
        $category = Category::where('title', 'awesome category')->get()->first();
        $this->assertEquals('cool category', $category->parent->title);
    }

    /** @test */
    public function multiple_category_ancestors() {
        $grandparent = Category::create([
            'title'=>'cool category',
            'title_meta'=>'cool category',
            'slug'=>'cool-category',
            'description'=>'cool description'
        ]);
        $parent = Category::create([
            'title'=>'nice category',
            'title_meta'=>'nice category',
            'slug'=>'nice-category',
            'description'=>'nice description',
            'parent_category_id'=>$grandparent->id
        ]);
        $this->post('/categories', [
            'title'=>'awesome category',
            'title_meta'=>'awesome category',
            'slug'=>'awesome-category',
            'description'=>'awesome description',
            'parent_category_id'=>$parent->id
        ]);
        $this->assertCount(3, Category::all());
        $category = Category::where('title', 'awesome category')->get()->first();
        $this->assertEquals('nice category', $category->parent->title);
        $this->assertEquals('cool category', $category->parent->parent->title);
    }

    /** @test */
    public function category_inputs_validation() {
        $response = $this->post('/categories', [
            'title'=>'cool category',
            'slug'=>'cool-category',
            'description'=>'cool description'
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title_meta']);
        $response = $this->post('/categories', ['parent_category_id'=>8475]);
        $response->assertSessionHasErrors(['title','title_meta','slug','description','parent_category_id']);
    }

    /** @test */
    public function category_title_metatitle_and_slug_should_be_unique() {
        Category::create([
            'title'=>'cool category',
            'title_meta'=>'cool category',
            'slug'=>'cool-category',
            'description'=>'cool description'
        ]);
        $response = 
            $this->post('/categories', ['title'=>'cool category', 'title_meta'=>'cool category','slug'=>'cool-category'])
            ->assertStatus(302)
            ->assertSessionHasErrors(['title','title_meta','slug']);
    }
}
