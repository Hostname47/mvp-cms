<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    
    protected $guarded = [];
    public $timestamps = false;
    
    public function getParentKeyName() {
        return 'parent_category_id';
    }

    public function ancestor() {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function subcategories() {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    public function posts() {
        return $this->belongsToMany(Post::class);
    }

    public function getMintitleAttribute() {
        return (strlen($this->title) > 46) ? substr($this->title, 0, 46) . '..' : $this->title;
    }

    public function getHasSubcategoriesAttribute() {
        return (bool) $this->subcategories->count();
    }

    public static function hot_categories() {
        /**
         * This should be cached
         */
        return Cache::remember('hot-categories', 21600, function () { // 6 hours
            return Category::withCount('posts')->orderBy('posts_count', 'desc')->take(10)->get();;
        });
    }

    public function as_tree() {
        return Cache::remember('tree', 86400, function () { // 6 hours
            return Category::tree()->get()->toTree();
        });
    }
}
