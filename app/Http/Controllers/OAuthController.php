<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User};
use Socialite;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->with(["prompt" => "select_account"])->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $provider) {
        $state = $request->get('state');
        $request->session()->put('state',$state);

        if(Auth::check()==false)
            session()->regenerate();
        
        $u = Socialite::driver($provider)->user();
        $user = User::withoutGlobalScopes()->where('email', $u->email)->first();

        /**
         * If the user is new to our system then we need to save its data to users table
         */
        if(!$user) {
            $names = explode(' ', $u->name);
            // create a new user
            $user = new User;
            $user->firstname = $names[0];
            $user->lastname = isset($names[1]) ? $names[1] : 'fibo';
            $user->username = 'fibo_' . str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
            $user->email = $u->email;
            $user->provider_id = $u->id;
            $user->provider = $provider;
            $user->avatar = null;
            $user->provider_avatar = $u->avatar_original;

            $user->save();
            $user->refresh();

            // Then we have to create folders that will hold user's media and files
            $path = public_path("/users/$user->id");
            File::makeDirectory($path, 0777, true, true);
            File::makeDirectory($path.'/usermedia/avatars', 0777, true, true);
            File::makeDirectory($path.'/usermedia/avatars/originals', 0777, true, true);
            File::makeDirectory($path.'/usermedia/avatars/segments', 0777, true, true);
            File::makeDirectory($path.'/usermedia/avatars/trash', 0777, true, true);
        }

        Auth::login($user, true);

        if(!is_null($user->deleted_at))
            \Session::flash('error', __('This account has already been deleted permanently.'));

        return redirect('/home');
    }
}
