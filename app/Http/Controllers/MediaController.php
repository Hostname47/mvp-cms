<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Metadata;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\View\Components\MediaLibrary\Image;

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
            }
            $file->storeAs('media-library', $filename);

            // file metadata
            $metadata = new Metadata;
            $metadata->key = 'attached_file';
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

    public function fetch_media(Request $request) {
        $data = $request->validate([
            'skip'=>'required|numeric',
            'take'=>'required|numeric',
            'form'=>['required', Rule::in(['raw', 'component'])]
        ]);

        $media = Metadata::where('key', 'attached_file')
            ->orderBy('created_at', 'desc')->skip($data['skip'])->take($data['take']+1)->get();
        $hasmore = $media->count() > $data['take'];
        $media = $media->take($data['take']);

        $payload="";
        switch($data['form']) {
            case 'raw':
                $payload = $media;
                break;
            case 'component':
                foreach($media as $media_item) {
                    /**
                     * Here we need to check the type of media (mime in value column); If the media
                     * is an image, then we have to use image component to represent the media
                     * 
                     * For MVP sake, we will asume that the app only support images
                     */
                    $imagecomponent = (new Image($media_item));
                    $imagecomponent = $imagecomponent->render(get_object_vars($imagecomponent))->render();
                    $payload .= $imagecomponent;
                }
                break;
        }

        return [
            'count'=>$media->count(),
            'hasmore'=>$hasmore,
            'payload'=>$payload,
        ];
    }
}
