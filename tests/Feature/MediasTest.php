<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
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
        (new Filesystem)->cleanDirectory(storage_path('app/testing'));
    }

    /** @test */
    public function upload_to_media_library() {
        Storage::fake('testing');
        $this->assertEquals(0, count(Storage::allFiles('media-library')));
        $this->post('/admin/media-library/upload', [
            'uploads'=>[UploadedFile::fake()->image('nassri.png', 30, 30)->size(200)]
        ]);
        $this->assertEquals(1, count(Storage::allFiles('media-library')));

        $this->post('/admin/media-library/upload', [
            'uploads'=>[UploadedFile::fake()->create('nassri.exe', 30, 30)->size(200)]
        ])->assertStatus(302)->assertSessionHasErrors(['uploads.*']);

        $this->post('/admin/media-library/upload', [
            'uploads'=>[UploadedFile::fake()->create('nassri.png', 30, 30)->size(7000)]
        ])->assertStatus(302)->assertSessionHasErrors(['uploads.*']);
    }
}
