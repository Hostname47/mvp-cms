<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{Role,Permission};

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create_a_role() {
        $this->assertCount(0, Role::all());
        $this->post('/admin/roles', ['title'=>'Admin','slug'=>'admin','description'=>'admin description']);
        $this->assertCount(1, Role::all());
    }
    /** @test */
    public function create_a_role_validation() {
        Role::create(['title'=>'Admin','slug'=>'admin','description'=>'admin description']);
        $this->post('/admin/roles', [
            'title'=>'Admin','slug'=>'admin','description'=>'admin description'
        ])->assertRedirect()->assertSessionHasErrors(['title','slug']); // Role already exists with that title and slug

        $this->post('/admin/roles', [
            'title'=>'Author','description'=>'author description'
        ])->assertRedirect()->assertSessionHasErrors(['slug']); // slug field is required
    }
    /** @test */
    public function update_a_role() {
        Role::create(['title'=>'Admib','slug'=>'admib','description'=>'admib description']);
        $role = Role::first();

        $this->assertEquals($role->title, 'Admib');
        $this->assertEquals($role->slug, 'admib');
        $this->assertEquals($role->description, 'admib description');
        $this->patch('/admin/roles', [
            'role_id'=>$role->id,
            'title'=>'Admin','slug'=>'admin','description'=>'admin description'
        ]);
        $role->refresh();
        $this->assertEquals($role->title, 'Admin');
        $this->assertEquals($role->slug, 'admin');
        $this->assertEquals($role->description, 'admin description');
    }
    /** @test */
    public function update_a_role_validation() {
        $siteowner = Role::create(['title'=>'Site Owner','slug'=>'site-owner','description'=>'site owner description']);
        $admin = Role::create(['title'=>'Admin','slug'=>'admin','description'=>'admin description']);

        $this->patch('/admin/roles', ['role_id'=>168945,'title'=>'Author'])
            ->assertRedirect()->assertSessionHasErrors(['role_id']); // invalid role id

        $this->patch('/admin/roles', ['role_id'=>$siteowner->id,'title'=>'Admin','slug'=>'admin'])
            ->assertRedirect()->assertSessionHasErrors(['title','slug']); // title and slug already exists in roles
    }
    /** @test */
    public function delete_a_role() {
        $role = Role::create(['title'=>'Admin','slug'=>'admin','description'=>'admin description']);

        $this->assertCount(1, Role::all());
        $this->delete('/admin/roles', ['role_id'=>$role->id]);
        $this->assertCount(0, Role::all());
    }
    /** @test */
    public function delete_site_owner_role_is_not_possible() {
        $role = Role::create(['title'=>'Site Owner','slug'=>'site-owner','description'=>'Site owner description']);

        $this->delete('/admin/roles', ['role_id'=>$role->id])
            ->assertStatus(422);
    }

    /** @test */
    public function attach_a_permission_to_role() {
        $permission = Permission::create(['title'=>'Create posts','slug'=>'create-a-post','description'=>'Create a post permission that allows user to create posts','scope'=>'posts']);
        $role = Role::create(['title'=>'Author','slug'=>'author','description'=>'author description']);

        $this->assertCount(0, $role->permissions);
        $this->post('/admin/roles/attach-permissions', [
            'role'=>$role->id,
            'permissions'=>[$permission->id]
        ]);
        $this->assertCount(1, $role->refresh()->permissions);
    }

    /** @test */
    public function detach_permission_from_role() {
        $this->withoutExceptionHandling();
        $permission0 = Permission::create(['title'=>'Create posts','slug'=>'create-a-post','description'=>'Create a post permission that allows user to create posts','scope'=>'posts']);
        $permission1 = Permission::create(['title'=>'Update posts','slug'=>'update-a-post','description'=>'Update a post permission that allows user to create posts','scope'=>'posts']);
        $role = Role::create(['title'=>'Author','slug'=>'author','description'=>'author description']);
        $role->permissions()->attach([$permission0->id, $permission1->id]);

        $this->assertCount(2, $role->refresh()->permissions);
        $this->post('/admin/roles/detach-permissions', [
            'role'=>$role->id,
            'permissions'=>[$permission0->id]
        ]);
        $this->assertCount(1, $role->refresh()->permissions);
    }
}
