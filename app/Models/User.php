<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{Role,RoleUser,Comment,Clap,Report,ContactMessage,Faq,SavedPost,Ban,AuthorRequest};
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

    public function author_requests() {
        return $this->hasMany(AuthorRequest::class);
    }

    public function contact_messages() {
        return $this->hasMany(ContactMessage::class);
    }

    public function faqs() {
        return $this->hasMany(Faq::class);
    }

    public function bans() {
        return $this->hasMany(Ban::class);
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
        return (new Carbon($this->created_at))->diffForHumans();
    }

    public function getJoinDateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY");
    }

    public function author_since($type="format") {
        $ar = $this->author_requests->where('status', 1)->first();

        if($ar) {
            switch($type) {
                case 'format':
                    return (new Carbon($ar->updated_at))->isoFormat("D-MM-YYYY - H:mm A");
                case 'humans':
                    return (new Carbon($ar->updated_at))->diffForHumans();
            }
        }
    }

    public function getScolorAttribute() {
        switch($this->status) {
            case 'active':
                return 'green';
            case 'banned':
            case 'temp-banned':
            case 'deleted':
                return 'red';
            default:
                return 'dark';
        }
    }

    public function attach_permission($slug) {
        $permission = Permission::where('slug', $slug)->first();
        $this->permissions()->syncWithoutDetaching($permission->id);
    }

    public function detach_permission($slug) {
        $permission = Permission::where('slug', $slug)->first();
        $this->permissions()->detach($permission->id);
    }

    public function grant_role($slug) {
        $role = Role::where('slug', $slug)->first();
        if(is_null($role)) return 0;
        $permissions = $role->permissions()->pluck('id')->toArray();

        $this->permissions()->syncWithoutDetaching($permissions);
        $role->users()->syncWithPivotValues($this->id, ['giver_id'=>auth()->user()->id], false);
    }

    public function revoke_role($slug) {
        $role = Role::where('slug', $slug)->first();
        if(is_null($role)) return 0;

        $permissions = $role->permissions()->pluck('id')->toArray();
        // Detach role permissions from user first, then we revoke the role
        $this->permissions()->detach($permissions);
        $role->users()->detach($this->id);
    }

    public function is_banned() {
        switch($this->status) {
            case 'banned':
                return true;
            case 'temp-banned':
                /**
                 * Here because we're using soft deleting in userban models we have to check whether it exists a userban
                 * record that is not soft deleted and not expired
                 */
                if($ban=$this->bans()->orderBy('created_at', 'desc')->first()) {
                    $now_in_seconds = Carbon::now()->timestamp;
                    $deadline_in_seconds = $ban->created_at->addDays($ban->ban_duration)->timestamp;
                    return $deadline_in_seconds - $now_in_seconds > 0; // user is banned if ban deadline is greather than the current(now) timestamp
                }
                return false;
        }

        return false;
    }

    public function is_author() {
        return $this->elected_author && $this->has_role('contributor-author');
    }
}
