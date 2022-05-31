<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,Permission};

class PermissionTest extends TestCase
{
    use DatabaseTransactions;
    
    protected $authuser;

    public function setUp(): void {
        parent::setUp();

        $user = $this->authuser = User::factory()->create();
        $this->actingAs($user);

        $permissions = [
            'access-admin-section' => Permission::factory()->create(['title'=>'aas', 'slug'=>'access-admin-section']),
            'create-permission' => Permission::factory()->create(['title'=>'cprm', 'slug'=>'create-permission']),
            'update-permission' => Permission::factory()->create(['title'=>'uprm', 'slug'=>'update-permission']),
            'delete-permission' => Permission::factory()->create(['title'=>'dprm', 'slug'=>'delete-permission']),
            'attach-permission-to-user' => Permission::factory()->create(['title'=>'aptu', 'slug'=>'attach-permission-to-user']),
            'detach-permission-from-user' => Permission::factory()->create(['title'=>'dpfu', 'slug'=>'detach-permission-from-user']),
        ];

        $user->attach_permission('access-admin-section');
        $user->attach_permission('create-permission');
        $user->attach_permission('update-permission');
        $user->attach_permission('delete-permission');
        $user->attach_permission('attach-permission-to-user');
        $user->attach_permission('detach-permission-from-user');
    }

    /** @test */
    public function create_a_permission() {
        $count = Permission::count();
        $this->post('/admin/permissions', ['title'=>'Create posts','slug'=>'create-a-post','description'=>'Create a post permission that allows user to create posts','scope'=>'posts']);
        $this->assertCount($count+1, Permission::all());
    }

    /** @test */
    public function create_a_permission_requires_permission() {
        $this->authuser->detach_permission('create-permission');
        $this->post('/admin/permissions', ['title'=>'foo','slug'=>'foo','description'=>'foo','scope'=>'foo'])
            ->assertForbidden();
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
    public function update_a_permission_require_permission() {
        $permission = Permission::create(['title'=>'foo','slug'=>'foo','description'=>'foo','scope'=>'foo']);
        $this->authuser->detach_permission('update-permission');
        $this->patch('/admin/permissions', [
            'permission_id'=>$permission->id,
            'title'=>'Create tags',
            'slug'=>'create-tags',
            'description'=>'create tags description',
            'scope'=>'tags',
        ])->assertForbidden();
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
        $permission = Permission::create(['title'=>'foo','slug'=>'foo','description'=>'foo','scope'=>'foo']);
        $count = Permission::count();
        $this->delete('/admin/permissions', ['permission_id'=>$permission->id]);
        $this->assertCount($count-1, Permission::all());
    }

    /** @test */
    public function delete_a_permission_require_permission() {
        $permission = Permission::create(['title'=>'foo','slug'=>'foo','description'=>'foo','scope'=>'foo']);
        $this->authuser->detach_permission('delete-permission');

        $this->delete('/admin/permissions', ['permission_id'=>$permission->id])
            ->assertForbidden();
    }

    /** @test */
    public function attach_permissions_to_users() {
        $user0 = User::factory()->create();
        $user1 = User::factory()->create();
        $permission0 = Permission::create(['title'=>'P0 title','slug'=>'p-0','description'=>'p0 desc','scope'=>'p0']);
        $permission1 = Permission::create(['title'=>'P1 title','slug'=>'p-1','description'=>'p1 desc','scope'=>'p1']);

        $this->assertCount(0, $user0->permissions);
        $this->assertCount(0, $user1->permissions);
        $this->post('/admin/users/attach-permissions', [
            'permissions'=>[$permission0->id, $permission1->id],
            'users'=>[$user0->id,$user1->id]
        ]);
        $this->assertCount(2, $user0->refresh()->permissions);
        $this->assertCount(2, $user1->refresh()->permissions);
        // Validation
        $this->post('/admin/users/attach-permissions', [
            'users'=>[$user0->id,$user1->id],
            'permissions'=>[$permission0->id, -85]
        ])->assertRedirect()->assertSessionHasErrors(['permissions.*']);
    }

    /** @test */
    public function attach_permissions_to_users_require_permission() {
        $user0 = User::factory()->create();
        $user1 = User::factory()->create();
        $permission0 = Permission::create(['title'=>'P0 title','slug'=>'p-0','description'=>'p0 desc','scope'=>'p0']);
        $permission1 = Permission::create(['title'=>'P1 title','slug'=>'p-1','description'=>'p1 desc','scope'=>'p1']);
        $this->authuser->detach_permission('attach-permission-to-user');

        $this->post('/admin/users/attach-permissions', [
            'permissions'=>[$permission0->id, $permission1->id],
            'users'=>[$user0->id,$user1->id]
        ])->assertForbidden();
    }

    /** @test */
    public function detach_permissions_from_users() {
        $user0 = User::factory()->create();
        $user1 = User::factory()->create();
        $permission0 = Permission::create(['title'=>'P0 title','slug'=>'p-0','description'=>'p0 desc','scope'=>'p0']);
        $permission1 = Permission::create(['title'=>'P1 title','slug'=>'p-1','description'=>'p1 desc','scope'=>'p1']);

        $user0->permissions()->attach([$permission0->id,$permission1->id]);
        $user1->permissions()->attach([$permission0->id,$permission1->id]);

        $this->assertCount(2, $user0->refresh()->permissions);
        $this->assertCount(2, $user1->refresh()->permissions);
        $this->post('/admin/users/detach-permissions', [
            'permissions'=>[$permission0->id, $permission1->id],
            'users'=>[$user0->id,$user1->id]
        ]);
        $this->assertCount(0, $user0->refresh()->permissions);
        $this->assertCount(0, $user1->refresh()->permissions);
    }

    
    /** @test */
    public function detach_permissions_from_users_require_permission() {
        $user0 = User::factory()->create();
        $user1 = User::factory()->create();
        $permission0 = Permission::create(['title'=>'P0 title','slug'=>'p-0','description'=>'p0 desc','scope'=>'p0']);
        $permission1 = Permission::create(['title'=>'P1 title','slug'=>'p-1','description'=>'p1 desc','scope'=>'p1']);

        $user0->permissions()->attach([$permission0->id,$permission1->id]);
        $user1->permissions()->attach([$permission0->id,$permission1->id]);
        $this->authuser->detach_permission('detach-permission-from-user');

        $this->post('/admin/users/detach-permissions', [
            'permissions'=>[$permission0->id, $permission1->id],
            'users'=>[$user0->id,$user1->id]
        ])->assertForbidden();
    }
}
