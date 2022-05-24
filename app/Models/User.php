<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{Role,RoleUser,Comment,Clap,Report,ContactMessage,Faq,SavedPost};
use Carbon\Carbon;

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

    public function is_admin() {
        return (bool) $this->roles()->whereIn('slug', ['admin','site-owner'])->count() > 0;
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function claps() {
        return $this->hasMany(Clap::class);
    }

    public function reportings() {
        return $this->hasMany(Report::class, 'reporter');
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function contact_messages() {
        return $this->hasMany(ContactMessage::class);
    }

    public function faqs() {
        return $this->hasMany(Faq::class);
    }

    public function posts_saved() {
        return $this->belongsToMany(Post::class, 'saved_posts', 'user_id', 'post_id')
            ->withTimestamps()
            ->orderBy('saved_posts.created_at', 'desc');
    }

    public function posts_claped() {
        return $this->belongsToMany(Post::class, 'claps', 'user_id', 'clapable_id')
        ->withTimestamps()
        ->withPivot('created_at')
        ->where('clapable_type', 'App\\Models\\Post')
        ->orderBy('claps.created_at', 'desc');
    }

    public function getHasAvatarAttribute() {
        return (is_null($this->avatar) && !is_null($this->provider_avatar)) || $this->avatar == 'file';
    }
    public function avatar($size, $quality="h") {
        if($this->has_avatar) {
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
    public function getSameAttribute() {
        return auth()->user() && auth()->user()->id == $this->id;
    }
    public function getLightusernameAttribute() {
        return strlen($this->username) > 14 ? substr($this->username, 0, 14) . '..' : $this->username;
    }
    public function high_role($eager=false) {
        if($eager)
            return $this->roles->sortBy('priority')->first();
            
        return $this->roles()->orderBy('priority')->first();
    }
    public function has_role($slug) {
        return (bool) $this->roles()->where('slug', $slug)->count() > 0;
    }
    public function has_permission($slug) {
        return (bool) $this->permissions()->where('slug', $slug)->count() > 0;
    }

    public function about($empty = '--') {
        return $this->empty ?? $empty;
    }

    public function getProfileAttribute() {
        return route('user.profile', ['user'=>$this->username]);
    }

    public function getJoinDateHumansAttribute() {
        return (new Carbon($this->updated_at))->diffForHumans();
    }

    public function getJoinDateAttribute() {
        return (new Carbon($this->updated_at))->isoFormat("dddd D MMM YYYY");
    }

    public function attach_permission($slug) {
        $permission = Permission::where('slug', $slug)->first();
        $this->permissions()->syncWithoutDetaching($permission->id);
    }

    public function detach_permission($slug) {
        $permission = Permission::where('slug', $slug)->first();
        $this->permissions()->detach($permission->id);
    }
}
