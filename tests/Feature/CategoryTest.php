<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{Post,Category,User,Permission};

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $authuser;
    protected $uncategorized;

    public function setUp(): void {
        parent::setUp();

        $this->uncategorized = Category::factory()->create([
            'title'=>'Uncategorized',
            'title_meta'=>'Uncategorized',
            'slug'=>'uncategorized',
        ]);

        $permissions = [
            'access-admin-section' => Permission::factory()->create(['title'=>'aas', 'slug'=>'access-admin-section']),
            'create-post' => Permission::factory()->create(['title'=>'cp', 'slug'=>'create-post']),
        ];

        $user = $this->authuser = User::factory()->create();
        $this->actingAs($user);
        $user->attach_permission('access-admin-section');
        $user->attach_permission('create-post');
    }

    /** @test */
    public function create_a_category() {
        $this->assertCount(1, Category::all()); // 1: because of uncategorized created in setup method
        $this->post('/admin/categories', [
            'title'=>'cool category',
            'title_meta'=>'cool category',
            'slug'=>'cool-category',
            'description'=>'cool description'
        ]);
        $this->assertCount(2, Category::all());
    }

    /** @test */
    public function create_a_category_with_parent() {
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
        $this->assertCount(3, Category::all());
        $category = Category::where('title', 'awesome category')->get()->first();
        $this->assertEquals('cool category', $category->ancestor->title);
    }

    /** @test */
    public function create_a_category_with_multiple_ancestors() {
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
        $this->assertCount(4, Category::all());
        $category = Category::where('title', 'awesome category')->get()->first();
        $this->assertEquals('nice category', $category->ancestor->title);
        $this->assertEquals('cool category', $category->ancestor->ancestor->title);
    }

    /** @test */
    public function create_a_category_validation() {
        $this->post('/admin/categories', ['title'=>'c','slug'=>'c','description'=>'c description'])
            ->assertRedirect()->assertSessionHasErrors(['title_meta']); // Title meta is required

        $this->post('/admin/categories', ['parent_category_id'=>847845])
            ->assertRedirect()->assertSessionHasErrors(['parent_category_id']); // Invalide parent category
    }

    /** @test */
    public function category_title_metatitle_and_slug_should_be_unique() {
        Category::create([
            'title'=>'cool category',
            'title_meta'=>'cool category',
            'slug'=>'cool-category',
            'description'=>'cool description'
        ]);

        $this->post('/admin/categories', ['title'=>'cool category', 'title_meta'=>'cool category','slug'=>'cool-category'])
            ->assertRedirect()
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
            'categories_priorities'=>[2, 1]
        ]);
        $this->assertEquals(2, $category1->refresh()->priority);
        $this->assertEquals(1, $category2->refresh()->priority);
    }

    /** @test */
    public function categories_priorities_update_validation() {
        // priority should be numeric and categories ids should exist
        $this->patch('/categories/priorities', [
            'categories_ids'=>[485, 548],
            'categories_priorities'=>['invalid-priority-value', 3]
        ])->assertRedirect()->assertSessionHasErrors(['categories_ids.*','categories_priorities.*']);
        // Number of categories should equal the number of priorities
        $category1 = Category::create(['title'=>'category 1','title_meta'=>'category 1','slug'=>'category 1','description'=>'category 1 description','priority'=>1]);
        $response = $this->patch('/categories/priorities', [
            'categories_ids'=>[$category1->id],
            'categories_priorities'=>[3, 5]
        ])->assertStatus(422);
    }

    /** @test */
    public function update_a_category() {
        $c1 = Category::create(['title'=>'cool category-a','title_meta'=>'cool category-a','slug'=>'cool-category-a','description'=>'cool description-a', 'priority'=>4]);
        $c2 = Category::create(['title'=>'cool category-b','title_meta'=>'cool category-b','slug'=>'cool-category-b','description'=>'cool description-b', 'priority'=>5]);
        
        $category = Category::create(['title'=>'cool category','title_meta'=>'cool category','slug'=>'cool-category','description'=>'cool description', 'priority'=>6, 'parent_category_id'=>$c1->id]);
        $this->patch('/admin/category', [
            'category_id'=>$category->id,
            'title'=>'new category',
            'title_meta'=>'new category',
            'slug'=>'new-category',
            'description'=>'new description',
            'priority'=>9,
            'parent_category_id'=>$c2->id
        ])->assertOk();
        $category->refresh();
        $this->assertEquals('new category', $category->title);
        $this->assertEquals('new category', $category->title_meta);
        $this->assertEquals('new-category', $category->slug);
        $this->assertEquals('new description', $category->description);
        $this->assertEquals(9, $category->priority);
        $this->assertEquals($c2->id, $category->parent_category_id);
    }

    /** @test */
    public function update_a_category_validation() {
        $category = Category::create(['title'=>'cool category','title_meta'=>'cool category','slug'=>'cool-category','description'=>'cool description', 'priority'=>6]);
        $this->patch('/admin/category', [
            'category_id'=>$category->id,
            'parent_category_id'=>54845 // Invalid parent category
        ])->assertRedirect()->assertSessionHasErrors(['parent_category_id']);

        $parent = Category::create(['title'=>'parent category','title_meta'=>'parent category','slug'=>'parent-category','description'=>'parent category description', 'priority'=>5]);
        $this->patch('/admin/category', [
            'category_id'=>$category->id,
            'parent_category_id'=>$parent->id
        ])->assertOk();

        $this->patch('/admin/category', [
            'category_id'=>$category->id,
            'title'=>\Illuminate\Support\Str::random(601) // Invalid title length category
        ])->assertRedirect()->assertSessionHasErrors(['title']);

        $this->patch('/admin/category', [
            'category_id'=>$category->id,
            'priority'=>'Invalid priority value' // Invalid title length category
        ])->assertRedirect()->assertSessionHasErrors(['priority']);
    }

    /** @test */
    public function updating_category_status() {
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
            ->assertRedirect()->assertSessionHasErrors(['status']);
        $this->patch('/admin/category/status', ['category_id'=>985478, 'status'=>'invalide status'])
            ->assertRedirect()->assertSessionHasErrors(['category_id','status']);
    }

    /** @test */
    public function update_category_parent() {
        $parent1 = Category::create(['title'=>'p1','title_meta'=>'p1','slug'=>'p1','description'=>'p1', 'priority'=>6]);
        $parent2 = Category::create(['title'=>'p1','title_meta'=>'p1','slug'=>'p1','description'=>'p1', 'priority'=>6]);
        $category = Category::create(['title'=>'cool category','title_meta'=>'cool category','slug'=>'cool-category','description'=>'cool description', 'priority'=>6, 'parent_category_id'=>$parent1->id]);
        $this->patch('/admin/category', [
            'category_id'=>$category->id,
            'parent_category_id'=>$parent2->id
        ]);
        $category->refresh();
        $this->assertEquals($parent2->id, $category->parent_category_id);
    }

    /** @test */
    public function a_category_could_not_be_a_parent_to_itself() {
        $category = Category::create(['title'=>'cool category','title_meta'=>'cool category','slug'=>'cool-category','description'=>'cool description', 'priority'=>6]);
        $this->patch('/admin/category', [
            'category_id'=>$category->id,
            'parent_category_id'=>$category->id
        ])->assertStatus(422);
    }

    /** @test */
    public function set_a_category_as_root_category() {
        $parent = Category::create(['title'=>'p1','title_meta'=>'p1','slug'=>'p1','description'=>'p1', 'priority'=>6]);
        $category = Category::create(['title'=>'cool category','title_meta'=>'cool category','slug'=>'cool-category','description'=>'cool description', 'priority'=>6, 'parent_category_id'=>$parent->id]);
        $this->assertEquals($parent->id, $category->parent_category_id);
        $response = $this->patch('/admin/category/set-as-root', [
            'category_id'=>$category->id,
        ]);
        $this->assertEquals($category->refresh()->parent_category_id, null);
    }

    /** @test */
    public function delete_a_category() {
        $category = Category::create(['title'=>'cool category','title_meta'=>'cool category','slug'=>'cool-category','description'=>'cool description', 'priority'=>6]);
        $this->assertCount(2, Category::all());
        $this->delete('/admin/categories', [
            'category_id'=>$category->id,
            'type'=>'delete-category-only'
        ]);
        $this->assertCount(1, Category::all());
    }

    /** @test */
    public function delete_a_category_will_make_all_its_subcategories_roots() {
        $category0 = Category::create(['title'=>'c0','title_meta'=>'c0','slug'=>'c0','description'=>'c0', 'priority'=>1]);
        $category1 = Category::create(['title'=>'c1','title_meta'=>'c1','slug'=>'c1','description'=>'c1', 'priority'=>2, 'parent_category_id'=>$category0->id]);
        
        $this->assertEquals($category1->parent_category_id, $category0->id);
        $this->delete('/admin/categories', [
            'category_id'=>$category0->id,
            'type'=>'delete-category-only'
        ]);
        $this->assertNull($category1->refresh()->parent_category_id);
    }

    /** @test */
    public function delete_a_category_and_all_its_subcategories() {
        $category0 = Category::create(['title'=>'c0','title_meta'=>'c0','slug'=>'c0','description'=>'c0','priority'=>1]);
        $category1 = Category::create(['title'=>'c1','title_meta'=>'c1','slug'=>'c1','description'=>'c1','priority'=>2,'parent_category_id'=>$category0->id]);
        $category2 = Category::create(['title'=>'c2','title_meta'=>'c2','slug'=>'c2','description'=>'c2','priority'=>3,'parent_category_id'=>$category1->id]);
        $category3 = Category::create(['title'=>'c3','title_meta'=>'c3','slug'=>'c3','description'=>'c3','priority'=>4,'parent_category_id'=>$category2->id]);

        $this->assertCount(5, Category::all());
        $this->delete('/admin/categories', [
            'category_id'=>$category0->id,
            'type'=>'delete-category-and-subcategories'
        ]);
        $this->assertCount(1, Category::all());
    }

    /** @test */
    public function delete_a_category_will_turn_posts_with_only_this_category_to_uncategorized() {
        $this->withoutExceptionHandling();
        $uncategorized = $this->uncategorized;
        // categories
        $category0 = Category::create(['title'=>'c0','title_meta'=>'c0','slug'=>'c0','description'=>'c0','priority'=>1]);
        $category1 = Category::create(['title'=>'c1','title_meta'=>'c1','slug'=>'c1','description'=>'c1','parent_category_id'=>$category0->id]);
        $category2 = Category::create(['title'=>'c2','title_meta'=>'c2','slug'=>'c2','description'=>'c2','parent_category_id'=>$category1->id]);
        $category3 = Category::create(['title'=>'c3','title_meta'=>'c3','slug'=>'c3','description'=>'c3','parent_category_id'=>$category2->id]);
        $other_category = Category::create(['title'=>'c3','title_meta'=>'c3','slug'=>'c3','description'=>'c3']);
        // Create a post in each category
        $this->post('/admin/posts', [
            'title'=>'p0','title_meta'=>'p0','slug'=>'p0','content'=>'content','categories'=>[$category0->id]
        ]);
        $this->post('/admin/posts', [
            'title'=>'p1','title_meta'=>'p1','slug'=>'p1','content'=>'content','categories'=>[$category1->id]
        ]);
        $this->post('/admin/posts', [
            'title'=>'p2','title_meta'=>'p2','slug'=>'p2','content'=>'content','categories'=>[$category2->id]
        ]);
        $this->post('/admin/posts', [
            'title'=>'p3','title_meta'=>'p3','slug'=>'p3','content'=>'content','categories'=>[$category3->id]
        ]);
        $this->post('/admin/posts', [
            'title'=>'p4','title_meta'=>'p4','slug'=>'p4','content'=>'content','categories'=>[$category3->id, $other_category->id]
        ]);
        
        $this->assertEquals(0, $uncategorized->posts->count());
        $this->delete('/admin/categories', [
            'category_id'=>$category0->id,
            'type'=>'delete-category-and-subcategories'
        ]);
        $this->assertEquals(4, $uncategorized->refresh()->posts->count());
        /**
         * Notice that p4 post will not be under uncategorized because it has other category ($other_category) which is 
         * not a descendent of the deleted category ($c0).
         */
    }
}
