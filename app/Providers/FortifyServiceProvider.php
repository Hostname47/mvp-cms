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
                        case 'deactivated':
                            return $user;
                            break;
                        case 'deleted':
                            \Session::flash('has-auth-error', 1);
                            \Session::flash('auth-error', __('This account has already been deleted permanently.'));
                            break;
                        case 'temp-banned':
                            /**
                             * We check if the duration of temporary ban is experid; If so we have to delete ban 
                             * record (soft delete it), and set user account status to live
                             */
                            $ban = $user->bans()->orderBy('created_at', 'desc')->where('ban_duration', '<>', -1)->first();
                            if(is_null($ban) || $ban->is_expired) {
                                $user->update(['status'=>'active']);
                                $ban->delete();

                                \Session::flash('message', __('Your account is active now. Frequent bans and strikes may cause your account to be terminated permanently.'));
                                return $user;
                            }
                            break;
                            \Session::flash('has-auth-error', 1);
                            \Session::flash('auth-error', __('Your account has been banned temporarily.'));
                        case 'banned':
                            \Session::flash('has-auth-error', 1);
                            \Session::flash('auth-error', __('Your account has been banned permanently.'));
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
