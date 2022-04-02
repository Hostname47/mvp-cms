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
    }
}
