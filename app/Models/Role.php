<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Permission,User,RoleUser};

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public function users() {
        return $this->belongsToMany(User::class)
            ->using(RoleUser::class)
            ->withPivot('giver_id');
    }

    public function getDescriptionSliceAttribute() {
        return strlen($this->description) > 100 ? substr($this->description, 0, 100) . '..' : $this->description;
    }
}
