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
            'uploads'=>"required|max:16",
            'uploads.*'=>"mimes:$allowed_mimes|max:8000"
        ])['uploads'];

        foreach($files as $file) {
            if(Storage::has('media-library/'.$file->name)) {
                $filename = pathinfo($file->name, PATHINFO_FILENAME);
                $extension = pathinfo($file->name, PATHINFO_EXTENSION);
                
                $i=1;
                while(Storage::has('media-library/'."$filename-$i.$extension")) $i++;
                $file->storeAs('media-library', "$filename-$i.$extension");
            }
            else
                $file->storeAs('media-library', $file->name);
        }
    }
}
