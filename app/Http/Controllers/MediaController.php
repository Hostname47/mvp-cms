<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function upload(Request $request) {
        $allowed_mimes = 'jpeg,png,jpg,gif,svg,jfif,bmp,tiff'; // images
        $allowed_mimes .= ',video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'; // videos
        $uploads = $request->validate([
            'uploads'=>"required|max:16",
            'uploads.*'=>"mimes:$allowed_mimes|max:8000"
        ])['uploads'];

        foreach($uploads as $upload) {
            $upload->store('media-library');
        }
    }
}
