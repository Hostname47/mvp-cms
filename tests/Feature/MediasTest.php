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

class MediasTest extends TestCase
{
    use DatabaseTransactions;
    
    public function setUp():void {
        parent::setUp();
        (new Filesystem)->cleanDirectory(storage_path('app/testing'));
    }

    public function tearDown():void {
        // (new Filesystem)->cleanDirectory(storage_path('app/testing'));
    }

    /** @test */
    public function upload_to_media_library() {
        $this->assertEquals(0, count(Storage::allFiles('media-library')));
        $image = UploadedFile::fake()->image('nassri.png', 30, 30)->size(200);
        $video = UploadedFile::fake()->create('forum-demo.mp4');
        $this->post('/admin/media-library/upload', [
            'uploads'=>[$image, $video]
        ]);
        $this->assertEquals(2, count(Storage::allFiles('media-library')));
    }

    /** @test */
    public function upload_to_media_library_validation() {
        $exe = UploadedFile::fake()->create('nassri.exe');
        $ai = UploadedFile::fake()->create('nassri.ai');
        $response = $this->post('/admin/media-library/upload', [
            'uploads'=>[$exe]
        ])->assertRedirect()->assertSessionHasErrors(['uploads.*']);
        $response = $this->post('/admin/media-library/upload', [
            'uploads'=>[$ai]
        ])->assertRedirect()->assertSessionHasErrors(['uploads.*']);
        // Testing file size
        $largemedia = UploadedFile::fake()->create('large-image.png')->size(8001);
        $this->post('/admin/media-library/upload', [
            'uploads'=>[$largemedia]
        ])->assertRedirect()->assertSessionHasErrors(['uploads.*']);

        // Testing number of uploaded files at the time
        $files = [];
        for($i=0;$i<19;$i++) { $files[] = UploadedFile::fake()->create(Str::random(10).'.png')->size(20); }

        $this->post('/admin/media-library/upload', [
            'uploads'=>$files
        ])->assertRedirect()->assertSessionHasErrors(['uploads']);
        $files = array_slice($files, 0, 16);
        $this->post('/admin/media-library/upload', [
            'uploads'=>$files
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
            'uploads'=>[$file1, $file2, $file3]
        ]);
        $this->assertEquals(3, count(Storage::allFiles('media-library')));
        $this->assertTrue(Storage::has('media-library/mouad-1.png'));
        $this->assertTrue(Storage::has('media-library/mouad-2.png'));
    }
}
