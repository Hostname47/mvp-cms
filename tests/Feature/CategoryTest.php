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
        $this->post('/admin/categories', [
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

        $this->post('/admin/categories', [
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
        $this->post('/admin/categories', [
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
        $response = $this->post('/admin/categories', [
            'title'=>'cool category',
            'slug'=>'cool-category',
            'description'=>'cool description'
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title_meta']);
        $response = $this->post('/admin/categories', ['parent_category_id'=>8475]);
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
            $this->post('/admin/categories', ['title'=>'cool category', 'title_meta'=>'cool category','slug'=>'cool-category'])
            ->assertStatus(302)
            ->assertSessionHasErrors(['title','title_meta','slug']);
    }

    /** @test */
    public function changing_categories_priorities() {
        $category1 = Category::create(['title'=>'category 1','title_meta'=>'category 1','slug'=>'category 1','description'=>'category 1 description','priority'=>1]);
        $category2 = Category::create(['title'=>'category 2','title_meta'=>'category 2','slug'=>'category 2','description'=>'category 2 description','priority'=>2]);
        $this->assertEquals(1, $category1->priority);
        $this->assertEquals(2, $category2->priority);
        $this->patch('/categories/priorities', [
            'categories_ids'=>[$category1->id, $category2->id],
            'categories_priorities'=>[2, 3]
        ]);
        $this->assertEquals(2, $category1->refresh()->priority);
        $this->assertEquals(3, $category2->refresh()->priority);
    }

    /** @test */
    public function categories_priorities_update_validation() {
        $response = $this->patch('/categories/priorities', [
            'categories_ids'=>[485, 548],
            'categories_priorities'=>['invalid-priority-value', 3]
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['categories_ids.*','categories_priorities.*']);

        $category1 = Category::create(['title'=>'category 1','title_meta'=>'category 1','slug'=>'category 1','description'=>'category 1 description','priority'=>1]);
        $response = $this->patch('/categories/priorities', [
            'categories_ids'=>[$category1->id],
            'categories_priorities'=>[3]
        ]);
        $this->assertEquals(3, $category1->refresh()->priority);
    }
}
