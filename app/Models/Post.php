<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Category,Tag, Metadata, Clap, SavedPost};
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'metadata' => 'array'
    ];

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function claps() {
        return $this->morphMany(Clap::class, 'clapable');
    }

    public function reports() {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function thumbnail() {
        return $this->belongsTo(Metadata::class, 'thumbnail_id');
    }

    public function getClapedAttribute() {
        if(!auth()->user())
            return false;
        return (boolean) $this->claps()->where('user_id', auth()->user()->id)->count();
    }

    public function getSavedAttribute() {
        if(!auth()->user())
            return false;
        return (boolean) SavedPost::where('user_id', auth()->user()->id)->where('post_id', $this->id)->count();
    }

    public function getCreationDateHumansAttribute() {
        return (new Carbon($this->created_at))->diffForHumans();
    }

    public function getCreationDateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    public function getUpdateDateHumansAttribute() {
        return (new Carbon($this->updated_at))->diffForHumans();
    }

    public function getUpdateDateAttribute() {
        return (new Carbon($this->updated_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    public function getPublishDateHumansAttribute() {
        return (new Carbon($this->published_at))->diffForHumans();
    }

    public function getPublishDateAttribute() {
        return (new Carbon($this->published_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    public function getShortPublishDateAttribute() {
        return (new Carbon($this->published_at))->isoFormat("MMMM D, YYYY");
    }

    public function has_thumbnail() {
        return (bool) $this->thumbnail;
    }

    public function getThumbnailImageAttribute() {
        if($this->thumbnail_id)
            return asset('media-library/'.$this->thumbnail->data['file']);

        return '';
    }

    public function getHtmlTitleAttribute() {
        // DOM Parser Object
        $html_dom = new \DOMDocument();
        @$html_dom->loadHTML($this->content);

        $title = $html_dom->getElementsByTagName('h1')[0];

        if($title)
            return $title->nodeValue;

        return $this->title;
    }

    public function getContentTitleSliceAttribute() {
        $title = $this->html_title;
        $length = 110;
        $slice = substr($title, 0, $length);
        return (strlen($title) > $length) ? $slice . '..' : $slice;
    }

    public function title($length) {
        $title = $this->html_title;
        $slice = substr($title, 0, $length);
        return (strlen($title) > $length) ? $slice . '..' : $slice;
    }

    public function getExcerptAttribute() {
        $excerpt = "";

        if($this->summary)
            $excerpt = $this->summary;
        else {
            // DOM Parser Object
            $html_dom = new \DOMDocument();
            @$html_dom->loadHTML($this->content);
            $excerpt = $html_dom->getElementsByTagName('p')->item(0)->nodeValue;
        }

        return Str::of($excerpt)->words(26, '..');
    }

    public function excerpt($length=26) {
        $excerpt = "";

        if($this->summary)
            $excerpt = $this->summary;
        else {
            // DOM Parser Object
            $html_dom = new \DOMDocument();
            @$html_dom->loadHTML($this->content);
            $excerpt = $html_dom->getElementsByTagName('p')->item(0)->nodeValue;
        }

        return Str::of($excerpt)->words($length, '..');
    }

    public function getLinkAttribute() {
        return route('view.post', ['category'=>$this->categories->first()->slug, 'post'=>$this->slug]);
    }

    public static function featured_posts() {
        return Cache::remember('featured-posts', 21600, function () { // 6 hours
            return Post::with(['categories','author', 'thumbnail', 'author.roles'])->orderBy('reactions_count', 'desc')->take(10)->get();
        });
    }
}
