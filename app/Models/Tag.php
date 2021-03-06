<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Post,Tag};
use Illuminate\Support\Facades\Cache;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    /**
     * This function accept multiple conditions to search for tag if exists. If exists then we return the first item,
     * otherwise, we create a new instance with the second data parameter
     */
    public static function first_or_create($conditions, $data) {
        $search = Tag::query();
        foreach($conditions as $key=>$value) $search = $search->orWhere($key, $value);
        return ($tag = $search->first()) ? $tag : Tag::create($data);
    }

    public function posts() {
        return $this->belongsToMany(Post::class);
    }

    public function hot_tags() {
        /**
         * This should be cached
         */
        return Cache::remember('hot-tags', 21600, function () { // 6 hours
            return Tag::withCount('posts')->orderBy('posts_count', 'desc')->take(10)->get();
        });
    }

    public function getPostsCountAttribute() {
        /**
         * This query should be cached because tags posts count is not changed frequently
         */
        return $this->posts()->count();
    }

    public function getLinkAttribute() {
        return route('tag.view', ['tag'=>$this->slug]);
    }
}
