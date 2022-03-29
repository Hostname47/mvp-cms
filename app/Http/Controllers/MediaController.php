<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Metadata;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function upload(Request $request) {
        $allowed_mimes = 'jpeg,png,jpg,gif,svg,jfif,bmp,tiff'; // images
        $allowed_mimes .= ',mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv'; // videos
        $files = $request->validate([
            'files'=>"required|max:16",
            'files.*'=>"mimes:$allowed_mimes|max:8000"
        ])['files'];

        foreach($files as $file) {
            $filename = $file->getClientOriginalName();
            if(Storage::has('media-library/'.$filename)) {
                $name = pathinfo($filename, PATHINFO_FILENAME);
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                $i=1;
                while(Storage::has('media-library/'."$name-$i.$extension")) $i++;
                $filename = "$name-$i.$extension";
                $file->storeAs('media-library', $filename);
            }
            else {
                $file->storeAs('media-library', $filename);
            }

            // file metadata
            $metadata = new Metadata;
            $metadata->key = 'attached-file';
            $mime = $file->getMimeType();
            $data = [
                'name'=>$filename,
                'mime'=>$mime,
                'size'=>$file->getSize()
            ];
            if(ImageHelper::is_image($mime)) { // If the file is an image, we add width and height dimensions to metadata
                try {
                    $dimensions = getimagesize(Storage::path('media-library/'.$filename));
                    $data['width'] = $dimensions[0];
                    $data['height'] = $dimensions[1];
                } catch(\Exception $ex) {
                    $data['width'] = -1;
                    $data['height'] = -1;
                }
            }
            $metadata->data = json_encode($data);
            $metadata->save();
        }
    }
}
