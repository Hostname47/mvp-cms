<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Clap;

class ClapController extends Controller
{
    public function clap(Request $request) {
        // Verify resource id and type
        $clapable_type = $request->validate(['clapable_type'=>Rule::in(['comment','post'])])['clapable_type'];
        $clapable_id = $request->validate(['clapable_id'=>'required|exists:'.$clapable_type.'s,id'])['clapable_id'];
        $data = [
            'clapable_id'=>$clapable_id,
            'clapable_type'=>$clapable_type,
        ];
        // Authorization
        $this->authorize('clap', [Clap::class, $data]);
        // Assign the current user id
        $data['user_id'] = auth()->user()->id;

        // Check if user already clap the resource (unclap) or it is the first time he clap
        $already = auth()->user()->claps()
            ->where('clapable_id', $data['clapable_id'])
            ->where('clapable_type', $data['clapable_type'])
            ->first();

        if($already) {
            $already->delete();
            return 0;
        } else {
            Clap::create($data);
            return 1;
        }
    }
}
