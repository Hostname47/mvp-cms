<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getDateHumansAttribute() {
        return (new Carbon($this->updated_at))->diffForHumans();
    }

    public function getDateAttribute() {
        return (new Carbon($this->updated_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }
}