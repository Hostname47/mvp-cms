<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\{User};

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public $authuser;

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
}
