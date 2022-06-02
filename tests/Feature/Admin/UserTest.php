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
use Carbon\Carbon;

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
            'unban-user' => Permission::factory()->create(['title'=>'uu', 'slug'=>'unban-user']),
        ];

        $user = $this->authuser = User::factory()->create();
        $this->actingAs($user);
        $user->attach_permission('access-admin-section');
        $user->attach_permission('ban-user');
        $user->attach_permission('unban-user');
    }

    /** @test */
    public function ban_a_user() {
        $user0 = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $user1 = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $banreason = BanReason::create(['title'=>'foo','slug'=>'foo']);
        $profile0 = route('user.profile', ['user' => $user0->username]);
        $profile1 = route('user.profile', ['user' => $user1->username]);
        $this->assertEquals('active', $user0->status);
        $this->assertCount(0, Ban::all());
        // Permanent ban
        $this->get($profile0)->assertOk();
        $this->post('/admin/users/ban', [
            'user_id'=>$user0->id,
            'ban_reason'=>$banreason->id,
            'type'=>'permanent'
        ]);
        $this->assertEquals('banned', $user0->refresh()->status);
        $this->assertCount(1, Ban::all());
        $this->get($profile0)->assertStatus(404);
        // Temporary ban
        $this->get($profile1)->assertOk();
        $this->post('/admin/users/ban', [
            'user_id'=>$user1->id,
            'ban_reason'=>$banreason->id,
            'ban_duration'=>7,
            'type'=>'temporary'
        ]);
        $this->assertEquals('temp-banned', $user1->refresh()->status);
        $this->assertCount(2, Ban::all());
        $this->get($profile1)->assertStatus(404);
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
    public function banned_user_cannot_access_his_account() {
        $user0 = User::factory()->create(['password'=>Hash::make('Hostname47'), 'status'=>'banned']);
        $user1 = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $banreason = BanReason::create(['title'=>'foo','slug'=>'foo']);

        $this->post('/admin/users/ban', [
            'user_id'=>$user1->id,
            'ban_reason'=>$banreason->id,
            'ban_duration'=>7,
            'type'=>'temporary'
        ]);

        $this->post('/logout'); // First logout the current user

        // Permanent ban
        $this->post('/login', [
            'email'=>$user0->email,
            'password'=>'Hostname47'
        ])->assertSessionHas('auth-error');
        $this->assertFalse(Auth::check());

        // Temporarily ban
        $user1 = $user1->refresh();
        $this->post('/login', [
            'email'=>$user1->email,
            'password'=>'Hostname47'
        ])->assertSessionHas('auth-error');
        $this->assertFalse(Auth::check());
    }

    /** @test */
    public function clear_expired_ban() {
        $user = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $banreason = BanReason::create(['title'=>'foo','slug'=>'foo']);

        $this->post('/admin/users/ban', [
            'user_id'=>$user->id,
            'ban_reason'=>$banreason->id,
            'ban_duration'=>7,
            'type'=>'temporary'
        ]);

        $ban = Ban::first();
        $user->refresh();
        // Let's expire the ban manually
        $this->assertFalse($ban->is_expired);
        $ban->update(['created_at'=>Carbon::now()->subDays(30)]);
        $this->assertTrue($ban->is_expired);

        $this->assertEquals('temp-banned', $user->status);
        $this->assertCount(1, Ban::all());
        $this->post('/admin/users/bans/clear-expired', [
            'user_id'=>$user->id
        ]);
        $this->assertEquals('active', $user->refresh()->status);
        $this->assertCount(0, Ban::all());
    }

    /** @test */
    public function clear_expired_ban_requires_permission() {
        $user = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $banreason = BanReason::create(['title'=>'foo','slug'=>'foo']);

        $this->post('/admin/users/ban', [
            'user_id'=>$user->id, 'ban_reason'=>$banreason->id, 'ban_duration'=>7, 'type'=>'temporary'
        ]);

        $ban = Ban::first();
        $ban->update(['created_at'=>Carbon::now()->subDays(30)]);
        $this->authuser->detach_permission('unban-user');

        $this->post('/admin/users/bans/clear-expired', [
            'user_id'=>$user->id
        ])->assertForbidden();
    }
}
