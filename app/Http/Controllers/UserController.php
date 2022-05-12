<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Helpers\ImageResize;

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

    public function profile_settings() {
        $page = 'profile-settings';
        $user = auth()->user();
        return view('settings.profile-settings')
            ->with(compact('user'))
            ->with(compact('page'));
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
            'avatar'=>'sometimes|file|image|mimes:jpg,gif,jpeg,bmp,png|max:5000|dimensions:min_width=20,min_height=20,max_width=2000,max_height=2000',
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
            $data['avatar'] = 'none';
        } else if($request->hasFile('avatar')) {
            /*
             * we are going to store the original avatar in avatars folder that contains all user avatars
             * and different dimensions of it in avatar folder
             */
            $path = $request->file('avatar')->storeAs(
                'users/' . $user->id . '/usermedia/avatars/originals', time() . '.png');
            // $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($path);
            $path = Storage::getDriver()->getAdapter()->applyPathPrefix($path);
            
            $avatar_dims = [[26, 50], [26, 100], [36, 50], [36, 100], [100, 50], [100, 100], [160, 50], [160, 100], [200, 60], [200, 100], [300, 70], [300, 100], [400, 80], [400, 100]];
            foreach($avatar_dims as $avatar_dim) {
                // *** 1) Initialise / load image
                $resizeObj = new ImageResize($path);

                // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
                $resizeObj->resizeImage($avatar_dim[0], $avatar_dim[0], 'crop');

                // $destination = storage_path('app/users/' . $user->id . '/usermedia/avatars/segments/' . $avatar_dim[0] . (($avatar_dim[1] == 100) ? '-h.png' : '-l.png'));
                // $destination = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($destination);
                $destination = '/users/' . $user->id . '/usermedia/avatars/segments/' . $avatar_dim[0] . (($avatar_dim[1] == 100) ? '-h.png' : '-l.png');
                $destination = Storage::getDriver()->getAdapter()->applyPathPrefix($destination);

                // *** 3) Save image ('image-name', 'quality [int]')
                $resizeObj->saveImage($destination, $avatar_dim[1]);
            }
            // Avatar path is not hard coded stored; Instead it is fetched from users storage based on user id
            $data['avatar'] = 'file';
        }

        unset($data['avatar_removed']);
        $user->update($data);
        \Session::flash('message', __('Your profile settings has been updated successfully'));
    }
}
