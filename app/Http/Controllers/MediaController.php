<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                $file->storeAs('media-library', "$name-$i.$extension");
            }
            else
                $file->storeAs('media-library', $filename);
        }
    }
}
