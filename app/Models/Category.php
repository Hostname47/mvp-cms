<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function parent() {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function subcategories() {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    public function getMintitleAttribute() {
        return (strlen($this->title) > 46) ? substr($this->title, 0, 46) . '..' : $this->title;
    }

    public function getHasSubcategoriesAttribute() {
        return (bool) $this->subcategories->count();
    }
}
