<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::withTrashed()->where('email', $request->email)
                ->orWhere('username', $request->email)
                ->first();

            if($user) {
                if(Hash::check($request->password, $user->password)) {
                    switch($user->status) {
                        case 'active':
                            return $user;
                            break;
                        case 'deleted':
                            \Session::flash('has-auth-error', 1);
                            \Session::flash('auth-error', __('This account has already been deleted permanently.'));
                            break;
                        case 'banned':
                            /** Handle banned user reaction */
                            break;
                    }
                } else {
                    \Session::flash('has-auth-error', 1);
                }
            } else
                \Session::flash('has-auth-error', 1);
        });

        // register new LoginResponse
        $this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );

        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register'); 
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(8)->by($email.$request->ip());
        });
    }
}
