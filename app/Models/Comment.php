<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User,Clap};
use Carbon\Carbon;

class Comment extends Model
{
    use HasFactory;
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function replies() {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }

    public function claps() {
        return $this->morphMany(Clap::class, 'clapable');
    }

    public function reports() {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function getParentKeyName() {
        return 'parent_comment_id';
    }

    public function getClapedAttribute() {
        if(!auth()->user())
            return false;
        return (boolean) $this->claps()->where('user_id', auth()->user()->id)->count();
    }

    public function getDateHumansAttribute() {
        return (new Carbon($this->created_at))->diffForHumans();
    }

    public function getDateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    public function getUpdatedAttribute() {
        return !$this->created_at->equalTo($this->updated_at);
    }
}
