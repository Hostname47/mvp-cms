<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Role,User};

class Permission extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function already_attached_to_role($roleslug) {
        return (bool) $this->roles->where('slug', $roleslug)->count() > 0;
    }
}
