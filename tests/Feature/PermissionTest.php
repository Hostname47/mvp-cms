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
        $this->withoutExceptionHandling();
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

}
