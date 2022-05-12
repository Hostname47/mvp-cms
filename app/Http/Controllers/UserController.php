<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    public function profile(User $user) {
        $roles = $user->roles;
        $hasrole = $roles->count() > 0;
        $hrole = $roles->sortBy('priority')->first();
        $posts = $user->posts()->with(['author','author.roles','categories','tags'])->orderBy('published_at', 'desc')->paginate(10);

        return view('user.profile')
            ->with(compact('user'))
            ->with(compact('hasrole'))
            ->with(compact('hrole'))
            ->with(compact('posts'))
            ->with(compact('roles'));
    }

    public function settings() {
        $user = auth()->user();
        return view('settings.profile-settings')
            ->with(compact('user'));
    }

    public function update_profile_settings(Request $request) {
        $user = auth()->user();

        $data = $this->validate($request, [
            'firstname'=>'sometimes|alpha|max:266',
            'lastname'=>'sometimes|alpha|max:266',
            'username'=> [
                'sometimes', 'alpha_dash', 'min:6', 'max:256',
                Rule::unique('users')->ignore($user->id),
            ],
            'about'=>'sometimes|max:1400',
            'avatar'=>'sometimes|file|image|mimes:jpg,gif,jpeg,bmp,png|max:5000|dimensions:min_width=20,min_height=10,max_width=2000,max_height=2000',
            'avatar_removed'=>['sometimes', Rule::in([0, 1])],
        ], [
            'firstname.alpha'=>__('Firstname must contain only letters'),
            'lastname.alpha'=>__('Lastname must contain only letters'),
            'username.alpha_dash'=>__('Username must contain only letters, numbers or dashes'),
            'username.min'=>__('Username must contain at least 6 characters'),
            'username.max'=>__('Username is too long'),
            'avatar.max'=>__('Avatar size should be less than 5MB'),
            'avatar.dimensions'=>__('Invalid avatar dimensions. (20px < width < 2000 - 20px < height < 2000)'),
        ]);

        if(isset($data['avatar_removed']) && $data['avatar_removed'] == 1) {
            $data['avatar'] = 'removed';
        } else if($request->hasFile('avatar')) {
            // Store avatar to file storage
            $data['avatar'] = 'file';
        }

        unset($data['avatar_removed']);
        $user->update($data);
        \Session::flash('message', __('Your profile settings has been updated successfully'));
    }
}
