<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

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
}
