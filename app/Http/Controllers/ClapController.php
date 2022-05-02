<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{Clap,Post,Comment};

class ClapController extends Controller
{
    public function clap(Request $request) {
        // Verify resource id and type
        $clapable_type = $request->validate([
            'clapable_type'=>['required', Rule::in(['comment','post'])]
        ])['clapable_type'];
        $clapable_id = $request->validate(['clapable_id'=>'required|exists:'.$clapable_type.'s,id'])['clapable_id'];
        $resource = null;
        switch($clapable_type) {
            case 'comment':
                $resource = Comment::find($clapable_id);
                break;
            case 'post':
                $resource = Post::find($clapable_id);
                break;
        }

        // Authorization
        $this->authorize('clap', [Clap::class, $resource]);
        // Assign the current user id
        $data = [
            'clapable_id'=>$clapable_id,
            'clapable_type'=>'App\Models\\' . ucfirst($clapable_type),
            'user_id'=>auth()->user()->id
        ];

        // Check if user already clap the resource (unclap) or it is the first time he clap
        $already = $resource->claps()->where('user_id', auth()->user()->id)->first();
        // Disable resource timestamps when modifying reactions_count column
        $resource->timestamps = false;
        if($already) {
            $already->delete();
            $resource->decrement('reactions_count');
            return 0;
        } else {
            Clap::create($data);
            $resource->increment('reactions_count');
            return 1;
        }
    }
}
