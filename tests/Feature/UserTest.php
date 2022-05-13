<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\{User};
use Laravel\Socialite\Contracts\Factory as Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\User as SocialUser;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;
    public $socialite_handled;

    public function setUp():void {
        parent::setUp();
        
        $this->authuser = $authuser = User::factory()->create();
        $this->actingAs($authuser);
        (new Filesystem)->cleanDirectory(storage_path('app/testing'));
    }

    public function tearDown():void {
        (new Filesystem)->cleanDirectory(storage_path('app/testing'));
    }

    /** @test */
    public function google_oauth_opened_successfully() {
        $this->post('/logout');
        $response = $this->get('/login/google');

        $response->assertStatus(302);
        $response->assertSee('google');
    }
    
    /** @test */
    public function facebbok_oauth_opened_successfully() {
        $this->post('/logout');
        $response = $this->get('/login/facebook');

        $response->assertStatus(302);
        $response->assertSee('facebook');
    }

    /** @test */
    public function user_signup_using_google_oauth() {
        $this->post('/logout');
        // Mock the Facade and return a User Object
        $this->mock_socialite_facade();
        
        $this->assertCount(1, User::all()); // 1 because we created one as auth user in 
        $response = $this->get('google/callback');
        $this->assertCount(2, User::all());
    }

    /** @test */
    public function user_could_not_register_using_usual_signup() { // Only oauth is supported now
        $this->assertCount(1, User::all());
        $response = $this->post('/register', [
            'firstname'=>'mouad',
            'lastname'=>'nassri',
            'username'=>'hostname47',
            'email'=>'qanon@hidden.com',
            'password'=>'Password54',
            'password_confirmation'=>'Password54'
        ]);
        $this->assertCount(1, User::all());
    }

    private function mock_socialite_facade($email='mouad@nassri.com', $token='foo', $id=1) {
        // mock users
        $socialiteUser = $this->createMock(SocialUser::class);
        $socialiteUser->token = $token;
        $socialiteUser->id = $id;
        $socialiteUser->email = $email;
        $socialiteUser->avatar_original = 'mouad.cdn.io/shut-the-fokirap';

        // mock provider
        $provider = $this->createMock(GoogleProvider::class);
        $provider->expects($this->any())
            ->method('user')
            ->willReturn($socialiteUser);

        $stub = $this->createMock(Socialite::class);
        $stub->expects($this->any())
            ->method('driver')
            ->willReturn($provider);

        // Replace Socialite Instance with our mock
        $this->app->instance(Socialite::class, $stub);
    }

    /** @test */
    public function update_user_profile_data() {
        $user = User::factory()->create([
            'firstname'=>'mouad',
            'lastname'=>'nassri',
            'username'=>'hostname47',
            'about'=>'something about me',
        ]);
        $this->actingAs($user);

        $this->post('/settings/profile', [
            'firstname'=>'thomas',
            'lastname'=>'acquinas',
            'username'=>'thomas86',
            'about'=>'Theology is important for everyone'
        ]);
        $user->refresh();
        $this->assertEquals('thomas', $user->firstname);
        $this->assertEquals('acquinas', $user->lastname);
        $this->assertEquals('thomas86', $user->username);
        $this->assertEquals('Theology is important for everyone', $user->about);
    }

    /** @test */
    public function update_user_profile_data_validation() {
        $user = $this->authuser;

        // Firstname and lastname should contain only characters
        $this->post('/settings/profile', ['firstname'=>'er854', 'lastname'=>'arros85po'])
            ->assertSessionHasErrors(['firstname', 'lastname']);
        $this->post('/settings/profile', ['firstname'=>str_repeat("a", 267)]) // firstname length is too long (max: 266)
            ->assertSessionHasErrors(['firstname']);
        $this->post('/settings/profile', ['username'=>'hello']) // username should have at least 6 chars
            ->assertSessionHasErrors(['username']);
        $this->post('/settings/profile', ['username'=>str_repeat("a", 257)]) // username length is too long (max: 256)
            ->assertSessionHasErrors(['username']);
        $this->post('/settings/profile', ['username'=>'gap god_gid']) // username should be alpha dashed
            ->assertSessionHasErrors(['username']);
        $this->post('/settings/profile', ['about'=>str_repeat("a", 1401)]) // about length is too long (max: 256)
            ->assertSessionHasErrors(['about']);
        $this->post('/settings/profile', ['avatar_removed'=>2]) // avatar_removed should be either 0 or 1
            ->assertSessionHasErrors(['avatar_removed']);
    }

    /** @test */
    public function avatar_sould_be_an_image() {
        $pdf = UploadedFile::fake()->create('eulises.pdf');
        $this->post('/settings/profile', ['avatar'=>$pdf]) 
            ->assertSessionHasErrors(['avatar']); // Avatar should be an image
    }

    /** @test */
    public function avatar_mime_validation() {
        $avatar = UploadedFile::fake()->image('eulises.webm');
        $this->post('/settings/profile', ['avatar'=>$avatar]) 
            ->assertSessionHasErrors(['avatar']); // only accept supported avatar mimes (currently webm is not supported)
    }

    /** @test */
    public function avatar_size_validation() {
        $avatar = UploadedFile::fake()->image('eulises.png', 100, 100)->size(5001);
        $this->post('/settings/profile', ['avatar'=>$avatar])
            ->assertSessionHasErrors(['avatar']); // avatar size should be less than 5MB
    }

    /** @test */
    public function avatar_dimensions_validation() {
        $avatar0 = UploadedFile::fake()->image('eulises0.png', 10, 10)->size(100);
        $avatar1 = UploadedFile::fake()->image('eulises1.png', 2001, 2001)->size(100);
        $this->post('/settings/profile', ['avatar'=>$avatar0])
            ->assertSessionHasErrors(['avatar']); // invalid dimensions
        $this->post('/settings/profile', ['avatar'=>$avatar1])
            ->assertSessionHasErrors(['avatar']); // invalid dimensions
    }

    /** @test */
    public function user_upload_avatar() {
        $user = $this->authuser;
        // Create avatars folders
        $path = Storage::getDriver()->getAdapter()->applyPathPrefix("/users/$user->id");
        File::makeDirectory($path.'/usermedia/avatars', 0777, true, true);
        File::makeDirectory($path.'/usermedia/avatars/originals', 0777, true, true);
        File::makeDirectory($path.'/usermedia/avatars/segments', 0777, true, true);
        $avatar = UploadedFile::fake()->image('eulises.png', 100, 100)->size(100);

        $this->assertNull($user->avatar);
        $this->assertEquals(0, count(Storage::allFiles("users/$user->id/usermedia/avatars/originals")));
        $this->assertEquals(0, count(Storage::allFiles("users/$user->id/usermedia/avatars/segments")));
        $this->post('/settings/profile', ['avatar'=>$avatar])->assertOk();
        $this->assertEquals(1, count(Storage::allFiles("users/$user->id/usermedia/avatars/originals")));
        $this->assertEquals(14, count(Storage::allFiles("users/$user->id/usermedia/avatars/segments")));
        $this->assertEquals($user->refresh()->avatar, 'file');
    }

    /** @test */
    public function user_set_first_password() {
        $user = User::factory()->create(['password'=>null]);
        $this->actingAs($user);

        $this->assertNull($user->password);
        $this->post('/settings/password/set', [
            'password'=>'Hostname1',
            'password_confirmation'=>'Hostname1'
        ]);
        $user->refresh();
        $this->assertTrue(!is_null($user->password));
    }

    /** @test */
    public function set_password_should_be_confirmed() {
        $user = User::factory()->create(['password'=>null]);
        $this->actingAs($user);

        $this->assertNull($user->password);
        $this->post('/settings/password/set', [
            'password'=>'Hostname1',
        ])->assertSessionHasErrors(['password']); // Missing password confirmation
        $this->post('/settings/password/set', [
            'password'=>'Hostname1',
            'password_confirmation'=>'Hostname2'
        ])->assertSessionHasErrors(['password']); // Invalide confirmation
    }

    /** @test */
    public function password_should_contain_at_least_8_characters() {
        $user = User::factory()->create(['password'=>null]);
        $this->actingAs($user);

        $this->assertNull($user->password);
        $this->post('/settings/password/set', [
            'password'=>'only',
        ])->assertSessionHasErrors(['password']);
        $this->post('/settings/password/set', [
            'password'=>'hello-darkness',
            'password_confirmation'=>'hello-darkness'
        ])->assertOk(); // Invalide confirmation
    }

    /** @test */
    public function user_can_set_password_only_once() {
        $user = User::factory()->create(['password'=>null]);
        $this->actingAs($user);

        $this->post('/settings/password/set', [
            'password'=>'Hostname1',
            'password_confirmation'=>'Hostname1'
        ])->assertOk();
        $this->post('/settings/password/set', [
            'password'=>'Hostname1',
            'password_confirmation'=>'Hostname1'
        ])->assertForbidden();
    }

    /** @test */
    public function update_password() {
        $user = User::factory()->create(['password'=>null]);
        $this->actingAs($user);

        $this->post('/settings/password/set', [
            'password'=>'Hostname1',
            'password_confirmation'=>'Hostname1'
        ]);
        $this->assertTrue(Hash::check('Hostname1', $user->password));
        $this->post('/settings/password/update', [
            'current_password'=>'Hostname1',
            'password'=>'FlimsyEntropy589',
            'password_confirmation'=>'FlimsyEntropy589'
        ]);
        $this->assertTrue(Hash::check('FlimsyEntropy589', $user->password));
    }

    /** @test */
    public function user_password_update_fail_if_current_password_is_wrong() {
        $user = User::factory()->create(['password'=>null]);
        $this->actingAs($user);

        $response = $this->post('/settings/password/set', [
            'password'=>'Hostname1',
            'password_confirmation'=>'Hostname1'
        ]);
        $response = $this->post('/settings/password/update', [
            'current_password'=>'Hostname89',
            'password'=>'FlimsyEntropy589',
            'password_confirmation'=>'FlimsyEntropy589'
        ])->assertStatus(422);
    }

    /** @test */
    public function user_deactivate_his_account() {
        $user = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $this->actingAs($user);

        $this->post('/settings/account/deactivate', ['password'=>'Hostname47']);
        $this->assertEquals('deactivated', $user->refresh()->status);
    }

    /** @test */
    public function deactivated_user_will_end_up_with_redirect_to_activation_page_in_every_request() {
        $user = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $this->actingAs($user);
        $this->post('/settings/account/deactivate', ['password'=>'Hostname47']);
        $this->actingAs($user);
        $this->get(route('discover'))->assertRedirect(route('user.account.activate'));
        $this->post('/settings/password/update', [
            'current_password'=>'Hostname1',
            'password'=>'FlimsyEntropy589',
            'password_confirmation'=>'FlimsyEntropy589'
        ])->assertRedirect(route('user.account.activate'));
    }

    /** @test */
    public function user_cannot_deactivate_deactivated_account() {
        $user = User::factory()->create(['password'=>Hash::make('Hostname47')]);
        $this->actingAs($user);
        $this->post('/settings/account/deactivate', ['password'=>'Hostname47'])->assertOk();
        $this->actingAs($user);
        $this->post('/settings/account/deactivate', ['password'=>'Hostname47'])->assertForbidden();
    }
}
