<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\{User,Permission,BanReason,Ban};

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;
    public $uncategorized;

    public function setUp():void {
        parent::setUp();

        $permissions = [
            'access-admin-section' => Permission::factory()->create(['title'=>'aas', 'slug'=>'access-admin-section']),
            'ban-user' => Permission::factory()->create(['title'=>'bu', 'slug'=>'ban-user']),
        ];

        $user = $this->authuser = User::factory()->create();
        $this->actingAs($user);
        $user->attach_permission('access-admin-section');
        $user->attach_permission('ban-user');
    }

    /** @test */
    public function ban_a_user_permanently() {
        $user = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $banreason = BanReason::create(['title'=>'foo','slug'=>'foo']);
        $profile = route('user.profile', ['user' => $user->username]);
        $this->assertEquals('active', $user->status);
        $this->assertCount(0, Ban::all());

        $this->get($profile)->assertOk();
        $this->post('/admin/users/ban', [
            'user_id'=>$user->id,
            'ban_reason'=>$banreason->id,
            'type'=>'permanent'
        ]);
        $this->assertEquals('banned', $user->refresh()->status);
        $this->assertCount(1, Ban::all());
        $this->get($profile)->assertStatus(404);
    }

    /** @test */
    public function ban_a_user_requires_permission() {
        $user = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $banreason = BanReason::create(['title'=>'foo','slug'=>'foo']);
        $this->authuser->detach_permission('ban-user');

        $this->post('/admin/users/ban', [
            'user_id'=>$user->id,
            'ban_reason'=>$banreason->id,
            'type'=>'permanent'
        ])->assertForbidden();
    }

    /** @test */
    public function permanent_banned_user_cannot_access_his_account() {
        $this->post('/logout'); // First logout the current user
        $user = User::factory()->create(['password'=>Hash::make('Hostname47'), 'status'=>'banned']);
        // $user is currently banned (has banned account status)
        $this->post('/login', [
            'email'=>$user->email,
            'password'=>'Hostname47'
        ])->assertSessionHas('auth-error');
        $this->assertFalse(Auth::check());
        // remove banned status and user can access his account
        $user->update(['status'=>'active']);
        $this->post('/login', [
            'email'=>$user->email,
            'password'=>'Hostname47'
        ]);
        $this->assertTrue(Auth::check());
    }
}
