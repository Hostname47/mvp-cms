<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Permission;

class PermissionTest extends TestCase
{
    use DatabaseTransactions;
    
    /** @test */
    public function create_a_permission() {
        $this->assertCount(0, Permission::all());
        $this->post('/admin/permissions', ['title'=>'Create posts','slug'=>'create-a-post','description'=>'Create a post permission that allows user to create posts','scope'=>'posts']);
        $this->assertCount(1, Permission::all());
    }

    /** @test */
    public function create_a_permission_validation() {
        Permission::create(['title'=>'Create posts','slug'=>'create-a-post','description'=>'Create a post permission that allows user to create posts','scope'=>'posts']);
        $this->post('/admin/permissions', [
            'title'=>'Create posts','slug'=>'create-a-post','description'=>'Create a post permission that allows user to create posts','scope'=>'posts'
        ])->assertRedirect()->assertSessionHasErrors(['title','slug']); // Permission already exists with that title and slug

        $this->post('/admin/permissions', [
            'title'=>'Create posts','slug'=>'create-a-post'
        ])->assertRedirect()->assertSessionHasErrors(['description','scope']); // desc and scope fields are required
    }

    /** @test */
    public function update_a_permission() {
        $permission = Permission::create(['title'=>'Create posts','slug'=>'create-a-post','description'=>'Create a post permission description','scope'=>'posts']);

        $this->assertEquals($permission->title, 'Create posts');
        $this->assertEquals($permission->slug, 'create-a-post');
        $this->assertEquals($permission->description, 'Create a post permission description');
        $this->assertEquals($permission->scope, 'posts');
        $this->patch('/admin/permissions', [
            'permission_id'=>$permission->id,
            'title'=>'Create tags',
            'slug'=>'create-tags',
            'description'=>'create tags description',
            'scope'=>'tags',
        ]);
        $permission->refresh();
        $this->assertEquals($permission->title, 'Create tags');
        $this->assertEquals($permission->slug, 'create-tags');
        $this->assertEquals($permission->description, 'create tags description');
        $this->assertEquals($permission->scope, 'tags');
    }

    /** @test */
    public function update_a_permission_validation() {
        $create_posts = Permission::create(['title'=>'Create posts','slug'=>'create-a-post','description'=>'Create a post permission that allows user to create posts','scope'=>'posts']);
        $create_tags = Permission::create(['title'=>'Create tags','slug'=>'create-a-tag','description'=>'Create a tag permission that allows user to create posts','scope'=>'tags']);

        $this->patch('/admin/permissions', ['permission_id'=>168945,'title'=>'Create categories'])
            ->assertRedirect()->assertSessionHasErrors(['permission_id']); // invalid permission id

        $this->patch('/admin/permissions', ['permission_id'=>$create_tags->id,'title'=>'Create posts','slug'=>'create-a-post'])
            ->assertRedirect()->assertSessionHasErrors(['title','slug']); // title and slug already exists
    }

    /** @test */
    public function delete_a_permission() {
        $this->withoutExceptionHandling();
        $permission = Permission::create(['title'=>'Create posts','slug'=>'create-a-post','description'=>'Create a post permission that allows user to create posts','scope'=>'posts']);

        $this->assertCount(1, Permission::all());
        $this->delete('/admin/permissions', ['permission_id'=>$permission->id]);
        $this->assertCount(0, Permission::all());
    }
}
