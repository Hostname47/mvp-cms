<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use App\Models\{Metadata, User, Permission};

class MediasTest extends TestCase
{
    use DatabaseTransactions;
    
    public $authuser;

    public function setUp():void {
        parent::setUp();

        $admin_access_permission = Permission::factory()->create([
            'title'=>'Access admin section',
            'slug'=>'access-admin-section'
        ]);
        $user = $this->authuser = User::factory()->create();
        $this->actingAs($user);
        $user->attach_permission('access-admin-section');

        (new Filesystem)->cleanDirectory(storage_path('app/testing'));
    }

    public function tearDown():void {
        (new Filesystem)->cleanDirectory(storage_path('app/testing'));
        parent::tearDown();
    }

    /** @test */
    public function upload_to_media_library() {
        $this->assertEquals(0, count(Storage::allFiles('media-library')));
        $image = UploadedFile::fake()->image('nassri.png', 30, 30)->size(200);
        $video = UploadedFile::fake()->create('forum-demo.mp4');
        $this->post('/admin/media-library/upload', [
            'files'=>[$image, $video]
        ]);
        $this->assertEquals(2, count(Storage::allFiles('media-library')));
    }

    /** @test */
    public function upload_to_media_library_validation() {
        $exe = UploadedFile::fake()->create('nassri.exe');
        $ai = UploadedFile::fake()->create('nassri.ai');
        $response = $this->post('/admin/media-library/upload', [
            'files'=>[$exe]
        ])->assertRedirect()->assertSessionHasErrors(['files.*']);
        $response = $this->post('/admin/media-library/upload', [
            'files'=>[$ai]
        ])->assertRedirect()->assertSessionHasErrors(['files.*']);
        // Testing file size
        $largemedia = UploadedFile::fake()->create('large-image.png')->size(8001);
        $this->post('/admin/media-library/upload', [
            'files'=>[$largemedia]
        ])->assertRedirect()->assertSessionHasErrors(['files.*']);

        // Testing number of uploaded files at the time
        $files = [];
        for($i=0;$i<19;$i++) { $files[] = UploadedFile::fake()->create(Str::random(10).'.png')->size(20); }

        $this->post('/admin/media-library/upload', [
            'files'=>$files
        ])->assertRedirect()->assertSessionHasErrors(['files']);
        $files = array_slice($files, 0, 16);
        $this->post('/admin/media-library/upload', [
            'files'=>$files
        ])->assertOk();
    }

    /** @test */
    public function file_already_exists_will_take_th_index_at_the_end_of_name() {
        $this->withoutExceptionHandling();
        $name = 'mouad';
        $file1 = UploadedFile::fake()->create('mouad.png');
        $file2 = UploadedFile::fake()->create('mouad.png');
        $file3 = UploadedFile::fake()->create('mouad.png');
        $this->post('/admin/media-library/upload', [
            'files'=>[$file1, $file2, $file3]
        ]);
        $this->assertEquals(3, count(Storage::allFiles('media-library')));
        $this->assertTrue(Storage::has('media-library/mouad-1.png'));
        $this->assertTrue(Storage::has('media-library/mouad-2.png'));
    }

    /** @test */
    public function update_file_metadata() {
        $image = UploadedFile::fake()->image('nassri.png', 30, 30)->size(200);
        $this->post('/admin/media-library/upload', [
            'files'=>[$image]
        ]);
        
        $metadata = Metadata::first();
        $data = $metadata->data;
        $this->assertFalse(array_key_exists('alt', $data));
        $this->assertFalse(array_key_exists('caption', $data));
        $this->assertFalse(array_key_exists('description', $data));
        $this->patch('/admin/media/metadata', [
            'metadata_id'=>$metadata->id,
            'keys'=>['alt','title','caption','description'],
            'values'=>['A new alt', 'The best title', 'A cool caption', 'Awesome description']
        ]);
        $metadata->refresh();
        $data = $metadata->data;
        $this->assertTrue(array_key_exists('alt', $data));
        $this->assertTrue(array_key_exists('caption', $data));
        $this->assertTrue(array_key_exists('description', $data));
    }

    /** @test */
    public function update_file_metadata_validation() {
        $image = UploadedFile::fake()->image('nassri.png', 30, 30)->size(200);
        $this->post('/admin/media-library/upload', [
            'files'=>[$image]
        ]);
        
        $metadata = Metadata::first();
        $data = $metadata->data;
        $this->patch('/admin/media/metadata', [
            'metadata_id'=>$metadata->id,
            'keys'=>['invalid-meta-key'],
            'values'=>['Invalid meta value']
        ])->assertRedirect()->assertSessionHasErrors(['keys.*']);

        $this->patch('/admin/media/metadata', [
            'metadata_id'=>$metadata->id,
            'keys'=>['alt'],
            'values'=>['alt value', 'invalid value']
        ])->assertStatus(422);
    }

    /** @test */
    public function delete_file_from_media_library() {
        $this->withoutExceptionHandling();

        $image = UploadedFile::fake()->image('nassri.png', 30, 30)->size(200);
        $this->post('/admin/media-library/upload', [
            'files'=>[$image]
        ]);
        $metadata = Metadata::first();

        $this->assertEquals(1, count(Storage::allFiles('media-library')));
        $this->assertCount(1, Metadata::all());
        $this->delete('/admin/media', [
            'metadata_id'=>$metadata->id
        ]);
        $this->assertEquals(0, count(Storage::allFiles('media-library')));
        $this->assertCount(0, Metadata::all());
    }
}
