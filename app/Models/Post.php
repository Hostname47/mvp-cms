<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
