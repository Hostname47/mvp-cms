<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Metadata;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
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

        $metadata_ids = [];
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
                'file'=>$filename,
                'mime'=>$mime,
                'size'=>$file->getSize(),
                'title'=> pathinfo($filename, PATHINFO_FILENAME)
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
            $metadata->data = $data;
            $metadata->save();

            $metadata_ids[] = $metadata->refresh()->id;
        }

        /**
         * After storing files and metadata of each one, we have to return the metadata ids to 
         * the request in order to build components and put them to media library
         */
        return [
            'metadata_ids'=>$metadata_ids
        ];
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
    public function fetch_media_set_components(Request $request) {
        $ids = $request->validate([
            'metadata_ids'=>'required',
            'metadata_ids.*'=>'exists:metadata,id',
        ])['metadata_ids'];

        $payload = "";
        foreach($ids as $id) {
            $metadata = Metadata::find($id);
            $imagecomponent = (new Image($metadata));
            $imagecomponent = $imagecomponent->render(get_object_vars($imagecomponent))->render();
            $payload .= $imagecomponent;
        }

        return [
            'count'=>count($ids),
            'payload'=>$payload,
        ];
    }

    public function update_file_metadata(Request $request) {
        $allowed_metadata_keys = ['alt','title','caption','description'];
        $data = $request->validate([
            'metadata_id'=>'required|exists:metadata,id',
            'keys'=>'required|max:20',
            'keys.*'=>[Rule::in($allowed_metadata_keys)],
            'values'=>'required|max:20',
            'values.*'=>'max:2000'
        ]);

        if(count($data['keys']) != count($data['values']))
            abort(422, 'Number of keys does not match the number of values');

        $metadata = Metadata::find($data['metadata_id']);
        $metadata_data = $metadata->data;
        $keys = $data['keys'];
        $values = $data['values'];
        $count = 0;
        foreach($keys as $key) {
            $metadata_data[$key] = is_null($values[$count]) ? '' : $values[$count];
            $count++;
        }


        $metadata->update(['data'=>$metadata_data]);
    }

    public function delete_media(Request $request) {
        $metadata_id = $request->validate([
            'metadata_id'=>'required|exists:metadata,id'
        ])['metadata_id'];
        $metadata = Metadata::find($metadata_id);

        Storage::delete('media-library/'.$metadata->data['file']); // First delete the file
        $metadata->delete(); // Then delete metadata
    }
}
