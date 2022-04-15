<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{Role,RoleUser};

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];
    private $avatar_dims = [26, 36, 100, 160, 200, 300, 400];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class)
            ->using(RoleUser::class)
            ->withPivot('giver_id');
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public function getHasAvatarAttribute() {
        if(is_null($this->avatar)) {
            /**
             * If user avatar is null we have to check avatar_provider. In case the provider_avatar is null, then
             * the user has deleted both avatar and provider avatar.
             */
            if(!is_null($this->provider_avatar))
                return true;
            else
                return false;
        }

        return true;
    }
    public function avatar($size, $quality="h") {
        if($this->hasavatar) {
            if(is_null($this->avatar))
                return $this->provider_avatar;
            else
                return asset("users/$this->id/usermedia/avatars/segments/$size-$quality.png");
        }

        return asset("storage/app/defaults/medias/avatars/$size-$quality.png");
    }
    public function defaultavatar($size, $quality="h") {
        return asset("storage/app/defaults/medias/avatars/$size-$quality.png");
    }
    public function getFullnameAttribute() {
        return $this->firstname . ' ' . $this->lastname;
    }
    public function getLightusernameAttribute() {
        return strlen($this->username) > 14 ? substr($this->username, 0, 14) . '..' : $this->username;
    }
    public function high_role() {
        return $this->roles->sortBy('priority')->first();
    }
    public function has_role($slug) {
        return (bool) $this->roles()->where('slug', $slug)->count() > 0;
    }
    public function has_permission($slug) {
        return (bool) $this->permissions()->where('slug', $slug)->count() > 0;
    }
}
