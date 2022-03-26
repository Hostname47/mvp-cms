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
        $this->assertEquals('cool category', $category->ancestor->title);
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
        $this->assertEquals('nice category', $category->ancestor->title);
        $this->assertEquals('cool category', $category->ancestor->ancestor->title);
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

    /** @test */
    public function updating_category() {
        $c1 = Category::create(['title'=>'cool category-a','title_meta'=>'cool category-a','slug'=>'cool-category-a','description'=>'cool description-a', 'priority'=>4]);
        $c2 = Category::create(['title'=>'cool category-b','title_meta'=>'cool category-b','slug'=>'cool-category-b','description'=>'cool description-b', 'priority'=>5]);
        $category = Category::create(['title'=>'cool category','title_meta'=>'cool category','slug'=>'cool-category','description'=>'cool description', 'priority'=>6, 'parent_category_id'=>$c1->id]);
        $response = $this->patch('/admin/category', [
            'category_id'=>$category->id,
            'title'=>'new category',
            'title_meta'=>'new category',
            'slug'=>'new-category',
            'description'=>'new description',
            'priority'=>9,
            'parent_category_id'=>$c2->id
        ]);
        $response->assertOk();
        $category->refresh();
        $this->assertEquals('new category', $category->title);
        $this->assertEquals('new category', $category->title_meta);
        $this->assertEquals('new-category', $category->slug);
        $this->assertEquals('new description', $category->description);
        $this->assertEquals(9, $category->priority);
        $this->assertEquals($c2->id, $category->parent_category_id);
    }

    /** @test */
    public function updating_category_validation() {
        $category = Category::create(['title'=>'cool category','title_meta'=>'cool category','slug'=>'cool-category','description'=>'cool description', 'priority'=>6]);
        $this->patch('/admin/category', [
            'category_id'=>$category->id,
            'parent_category_id'=>54845 // Invalid parent category
        ])->assertStatus(302)->assertSessionHasErrors(['parent_category_id']);
        $parent = Category::create(['title'=>'parent category','title_meta'=>'parent category','slug'=>'parent-category','description'=>'parent category description', 'priority'=>5]);
        $this->patch('/admin/category', [
            'category_id'=>$category->id,
            'parent_category_id'=>$parent->id // Invalid parent category
        ])->assertOk();
        $this->patch('/admin/category', [
            'category_id'=>$category->id,
            'title'=>\Illuminate\Support\Str::random(601) // Invalid title length category
        ])->assertStatus(302)->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function updating_category_status() {
        $this->withoutExceptionHandling();
        $category = Category::create(['title'=>'cool category','title_meta'=>'cool category','slug'=>'cool-category','description'=>'cool description', 'status'=>'awaiting review', 'priority'=>6]);
        $this->assertEquals('awaiting review', $category->status);
        $this->patch('/admin/category/status', [
            'category_id'=>$category->id,
            'status'=>'live'
        ]);
        $this->assertEquals('live', $category->refresh()->status);
    }

    /** @test */
    public function updating_category_status_will_update_all_its_subcategories_of_all_levels() {
        $c0 = Category::create(['title'=>'c0','title_meta'=>'c0','slug'=>'c0','description'=>'c0', 'status'=>'awaiting review', 'priority'=>0]);
        $c1 = Category::create(['title'=>'c1','title_meta'=>'c1','slug'=>'c1','description'=>'c1', 'status'=>'awaiting review', 'priority'=>1, 'parent_category_id'=>$c0->id]);
        $c2 = Category::create(['title'=>'c2','title_meta'=>'c2','slug'=>'c2','description'=>'c2', 'status'=>'awaiting review', 'priority'=>2, 'parent_category_id'=>$c1->id]);
        $c3 = Category::create(['title'=>'c3','title_meta'=>'c3','slug'=>'c3','description'=>'c3', 'status'=>'awaiting review', 'priority'=>3, 'parent_category_id'=>$c2->id]);
        
        $this->patch('/admin/category/status', [
            'category_id'=>$c0->id,
            'status'=>'live'
        ]);

        $c0->refresh(); $c1->refresh(); $c2->refresh(); $c3->refresh();
        $this->assertEquals('live', $c0->status);
        $this->assertEquals('live', $c1->status);
        $this->assertEquals('live', $c2->status);
        $this->assertEquals('live', $c3->status);
    }

    /** @test */
    public function update_category_status_validation() {
        $c0 = Category::create(['title'=>'c0','title_meta'=>'c0','slug'=>'c0','description'=>'c0', 'status'=>'awaiting review', 'priority'=>0]);
        $this->patch('/admin/category/status', ['category_id'=>$c0->id, 'status'=>'invalide status'])
            ->assertStatus(302)->assertSessionHasErrors(['status']);
        $this->patch('/admin/category/status', ['category_id'=>985478, 'status'=>'invalide status'])
            ->assertStatus(302)->assertSessionHasErrors(['category_id','status']);
    }
}
