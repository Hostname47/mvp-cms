<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,Role,Permission,RoleUser,PermissionUser};

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * The relation between roles-permissions-users could be messy if we start to attach
     * permissions just randomely without paying care about some tiny details.
     * 
     * The following rules are required and are best practices that will let the flow
     * much more performant and easier to handle.
     * 
     * • Permissions should be tied to one and only one role; means a permission should not belong to multiple
     *   roles at the same time. If an admin want to update a post, he must have Author role.
     *   By following that convention, we should not care about permissions cascading delete when a role
     *   get deleted or revoked from a user that have a role with high priority. we just revoke the role permissions
     *   from all role users. Let's take an example to understand
     *   this point:
     *   Let's say thomas has 2 roles : admin and author, and author role has create post permission.
     *   Now if we detach create post permission from author role, all role owners (including thomas - admin)
     *   will no longer has create post permission even if role users include site owners. 
     *   If tomas want to create a post, he need to attach the permission to author again or attach it to admin 
     *   which is not advisable to have a permission belong to multiple roles.
     *   By following this rule, all permissions should be attached to at least one role; If a permission does not
     *   belong to any role, it will be orphaned and the activity attached to it will not be possible to be performed.
     *   For that reason site owners should pay much more care about this.
     * 
     * • Principle of least privilege : If a user is admin and not an author, just give him admin role; Meaning we
     *   could have an admin that could not create posts. If a user is a good author, he should only have author 
     *   role. But we can have a memeber with the two roles or more. 
     *   The same concept applied to displaying views, sections and pages; An author should not have the right
     *   to access the admin panel.
     */

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
    public function delete_a_role_will_delete_all_associated_users_and_permissions() {
        $authuser = User::factory()->create();
        $this->actingAs($authuser);
        $role = Role::create(['title'=>'Author','slug'=>'author','description'=>'author description']);
        $user0 = User::factory()->create();
        $user1 = User::factory()->create();
        $permission0 = Permission::create(['title'=>'P0 title','slug'=>'p-0','description'=>'p0 desc','scope'=>'p0']);
        $permission1 = Permission::create(['title'=>'P1 title','slug'=>'p-1','description'=>'p1 desc','scope'=>'p1']);
        $permission2 = Permission::create(['title'=>'P2 title','slug'=>'p-2','description'=>'p2 desc','scope'=>'p2']);

        $this->post('/admin/roles/grant-to-users', [
            'role'=>$role->id,
            'users'=>[$user0->id,$user1->id]
        ]);
        $this->post('/admin/roles/attach-permissions', [
            'role'=>$role->id,
            'permissions'=>[$permission0->id, $permission1->id, $permission2->id]
        ]);
        $this->assertCount(2, RoleUser::all());
        $this->assertCount(6, PermissionUser::all());
        $this->delete('/admin/roles', ['role_id'=>$role->id]);
        $this->assertCount(0, RoleUser::all());
        $this->assertCount(0, PermissionUser::all());
    }

    /** @test */
    public function attach_permissions_to_role() {
        $permission = Permission::create(['title'=>'Create posts','slug'=>'create-a-post','description'=>'Create a post permission that allows user to create posts','scope'=>'posts']);
        $role = Role::create(['title'=>'Author','slug'=>'author','description'=>'author description']);

        $this->assertCount(0, $role->permissions);
        $this->post('/admin/roles/attach-permissions', [
            'role'=>$role->id,
            'permissions'=>[$permission->id]
        ]);
        $this->assertCount(1, $role->refresh()->permissions);

        // Attach multiple permissions
        $permission0 = Permission::create(['title'=>'P0 title','slug'=>'p-0','description'=>'p0 desc','scope'=>'p0']);
        $permission1 = Permission::create(['title'=>'P1 title','slug'=>'p-1','description'=>'p1 desc','scope'=>'p1']);
        $this->post('/admin/roles/attach-permissions', [
            'role'=>$role->id,
            'permissions'=>[$permission0->id,$permission1->id]
        ]);
        $this->assertCount(3, $role->refresh()->permissions);
        // Validation
        $this->post('/admin/roles/attach-permissions', [
            'role'=>$role->id,
            'permissions'=>[$permission->id, -85]
        ])->assertRedirect()->assertSessionHasErrors(['permissions.*']);
    }
    /** @test */
    public function detach_permission_from_role() {
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

        // Validation (detach a permission that the role does not have)
        $permission2 = Permission::create(['title'=>'Delete posts','slug'=>'delete-a-post','description'=>'Delete a post permission that allows user to create posts','scope'=>'posts']);
        $this->assertCount(1, $role->refresh()->permissions);
        $this->post('/admin/roles/detach-permissions', [
            'role'=>$role->id,
            'permissions'=>[$permission2->id]
        ]);
        $this->assertCount(1, $role->refresh()->permissions);
    }

    /** @test */
    public function attach_permissions_to_role_will_attach_them_to_all_role_owners() {
        $authuser = User::factory()->create();
        $this->actingAs($authuser);
        $role = Role::create(['title'=>'Author','slug'=>'author','description'=>'author description']);

        $user0 = User::factory()->create();
        $user1 = User::factory()->create();

        $permission0 = Permission::create(['title'=>'P0 title','slug'=>'p-0','description'=>'p0 desc','scope'=>'p0']);
        $permission1 = Permission::create(['title'=>'P1 title','slug'=>'p-1','description'=>'p1 desc','scope'=>'p1']);
        $permission2 = Permission::create(['title'=>'P2 title','slug'=>'p-2','description'=>'p2 desc','scope'=>'p2']);

        $this->post('/admin/roles/grant-to-users', [
            'role'=>$role->id,
            'users'=>[$user0->id,$user1->id]
        ]);
        $this->assertCount(0, $user0->refresh()->permissions);
        $this->assertCount(0, $user1->refresh()->permissions);
        /**
         * By attaching the 3 permissions to the role, all role owners should get those permissions
         */
        $this->post('/admin/roles/attach-permissions', [
            'role'=>$role->id,
            'permissions'=>[$permission0->id, $permission1->id, $permission2->id]
        ]);
        $this->assertCount(3, $user0->refresh()->permissions);
        $this->assertCount(3, $user1->refresh()->permissions);
    }
    /** @test */
    public function detach_permissions_from_role_will_detach_them_from_all_role_owners() {
        $authuser = User::factory()->create();
        $this->actingAs($authuser);
        $role = Role::create(['title'=>'Author','slug'=>'author','description'=>'author description']);
        $user0 = User::factory()->create();
        $user1 = User::factory()->create();
        $permission0 = Permission::create(['title'=>'P0 title','slug'=>'p-0','description'=>'p0 desc','scope'=>'p0']);
        $permission1 = Permission::create(['title'=>'P1 title','slug'=>'p-1','description'=>'p1 desc','scope'=>'p1']);
        $permission2 = Permission::create(['title'=>'P2 title','slug'=>'p-2','description'=>'p2 desc','scope'=>'p2']);
        // Attach 3 permissions to role
        $this->post('/admin/roles/attach-permissions', [
            'role'=>$role->id,
            'permissions'=>[$permission0->id, $permission1->id, $permission2->id]
        ]);
        // Then grant that role to users (they will get all permissions)
        $this->post('/admin/roles/grant-to-users', [
            'role'=>$role->id,
            'users'=>[$user0->id,$user1->id]
        ]);
        $this->assertCount(3, $user0->permissions);
        $this->assertCount(3, $user1->permissions);
        /**
         * By detaching the 3 permissions from the role, all role owners should lose those permissions
         */
        $this->post('/admin/roles/detach-permissions', [
            'role'=>$role->id,
            'permissions'=>[$permission0->id, $permission1->id, $permission2->id]
        ]);
        $this->assertCount(0, $user0->refresh()->permissions);
        $this->assertCount(0, $user1->refresh()->permissions);
    }

    /** @test */
    public function grant_role_to_user() {
        $authuser = User::factory()->create();
        $this->actingAs($authuser);
        $role = Role::create(['title'=>'Author','slug'=>'author','description'=>'author description']);
        $user = User::factory()->create();

        $this->assertCount(0, $user->roles);
        $this->post('/admin/roles/grant-to-users', [
            'role'=>$role->id,
            'users'=>[$user->id]
        ]);
        $this->assertCount(1, $user->refresh()->roles);
        $this->assertEquals($authuser->id, $user->refresh()->roles->first()->pivot->giver->id);
    }
    /** @test */
    public function grant_a_role_will_attach_all_its_associated_permissions_to_role_owners() {
        $authuser = User::factory()->create();
        $this->actingAs($authuser);
        $role = Role::create(['title'=>'Author','slug'=>'author','description'=>'author description']);
        $user = User::factory()->create();

        $permission0 = Permission::create(['title'=>'P0 title','slug'=>'p-0','description'=>'p0 desc','scope'=>'p0']);
        $permission1 = Permission::create(['title'=>'P1 title','slug'=>'p-1','description'=>'p1 desc','scope'=>'p1']);
        $permission2 = Permission::create(['title'=>'P2 title','slug'=>'p-2','description'=>'p2 desc','scope'=>'p2']);
        $this->post('/admin/roles/attach-permissions', [
            'role'=>$role->id,
            'permissions'=>[$permission0->id, $permission1->id, $permission2->id]
        ]);
        $this->assertCount(0, $user->permissions);
        $this->post('/admin/roles/grant-to-users', [
            'role'=>$role->id,
            'users'=>[$user->id]
        ]);
        $this->assertCount(3, $user->refresh()->permissions);

        // Some validations
        $this->assertCount(1, $user->roles);
        $this->post('/admin/roles/grant-to-users', [
            'role'=>$role->id,
            'users'=>[$user->id]
        ]);
        $this->assertCount(1, $user->refresh()->roles); // Already has this role so it should be 1 still
        $this->assertCount(3, $user->refresh()->permissions);
    }
    /** @test */
    public function grant_role_to_multiple_users_to_check_permissions_assignments() {
        $authuser = User::factory()->create();
        $this->actingAs($authuser);
        $role = Role::create(['title'=>'Author','slug'=>'author','description'=>'author description']);
        $user0 = User::factory()->create();
        $user1 = User::factory()->create();

        $permission0 = Permission::create(['title'=>'P0 title','slug'=>'p-0','description'=>'p0 desc','scope'=>'p0']);
        $permission1 = Permission::create(['title'=>'P1 title','slug'=>'p-1','description'=>'p1 desc','scope'=>'p1']);
        $permission2 = Permission::create(['title'=>'P2 title','slug'=>'p-2','description'=>'p2 desc','scope'=>'p2']);
        $role->permissions()->attach([$permission0->id,$permission1->id,$permission2->id]);

        $this->assertCount(0, $user0->permissions);
        $this->assertCount(0, $user1->permissions);
        $this->post('/admin/roles/grant-to-users', [
            'role'=>$role->id,
            'users'=>[$user0->id, $user1->id]
        ]);
        $this->assertCount(3, $user0->refresh()->permissions);
        $this->assertCount(3, $user1->refresh()->permissions);
    }
    /** @test */
    public function revoke_role_from_user() {
        $this->withoutExceptionHandling();
        $authuser = User::factory()->create();
        $this->actingAs($authuser);
        $role = Role::create(['title'=>'Author','slug'=>'author','description'=>'author description']);
        $user = User::factory()->create();

        $this->post('/admin/roles/grant-to-users', [
            'role'=>$role->id,
            'users'=>[$user->id]
        ]);
        $this->assertCount(1, $user->refresh()->roles);
        $this->post('/admin/roles/revoke-from-users', [
            'role'=>$role->id,
            'users'=>[$user->id]
        ]);
        $this->assertCount(0, $user->refresh()->roles);
    }
    /** @test */
    public function revoke_role_from_user_will_revoke_all_its_associated_permissions_as_well() {
        $authuser = User::factory()->create();
        $this->actingAs($authuser);
        $role = Role::create(['title'=>'Author','slug'=>'author','description'=>'author description']);
        $user = User::factory()->create();

        $permission0 = Permission::create(['title'=>'P0 title','slug'=>'p-0','description'=>'p0 desc','scope'=>'p0']);
        $permission1 = Permission::create(['title'=>'P1 title','slug'=>'p-1','description'=>'p1 desc','scope'=>'p1']);
        $permission2 = Permission::create(['title'=>'P2 title','slug'=>'p-2','description'=>'p2 desc','scope'=>'p2']);
        $role->permissions()->attach([$permission0->id,$permission1->id,$permission2->id]);

        $this->assertCount(0, $user->permissions);
        $this->post('/admin/roles/grant-to-users', ['role'=>$role->id,'users'=>[$user->id]]);
        $this->assertCount(3, $user->refresh()->permissions);
        $this->post('/admin/roles/revoke-from-users', ['role'=>$role->id,'users'=>[$user->id]]);
        $this->assertCount(0, $user->refresh()->permissions);
    }
    /** @test */
    public function revoke_role_from_multiple_users_to_check_permissions_detachments() {
        $authuser = User::factory()->create();
        $this->actingAs($authuser);
        $role = Role::create(['title'=>'Author','slug'=>'author','description'=>'author description']);
        $user0 = User::factory()->create();
        $user1 = User::factory()->create();

        $permission0 = Permission::create(['title'=>'P0 title','slug'=>'p-0','description'=>'p0 desc','scope'=>'p0']);
        $permission1 = Permission::create(['title'=>'P1 title','slug'=>'p-1','description'=>'p1 desc','scope'=>'p1']);
        $permission2 = Permission::create(['title'=>'P2 title','slug'=>'p-2','description'=>'p2 desc','scope'=>'p2']);
        $role->permissions()->attach([$permission0->id,$permission1->id,$permission2->id]);

        $this->assertCount(0, $user0->permissions);
        $this->assertCount(0, $user1->permissions);
        $this->post('/admin/roles/grant-to-users', ['role'=>$role->id,'users'=>[$user0->id, $user1->id]]);
        $this->assertCount(3, $user0->refresh()->permissions);
        $this->assertCount(3, $user1->refresh()->permissions);
        $this->post('/admin/roles/revoke-from-users', ['role'=>$role->id,'users'=>[$user0->id, $user1->id]]);
        $this->assertCount(0, $user0->refresh()->permissions);
        $this->assertCount(0, $user1->refresh()->permissions);
    }
}
