<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\User;

class RoleUser extends Pivot
{
    protected $table = 'role_user';

    public function giver() {
        return $this->belongsTo(User::class, 'giver_id');
    }
}
