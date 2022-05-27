<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

class Report extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function report_user() {
        return $this->belongsTo(User::class, 'reporter');
    }

    public function getDateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("D-M-YYYY - H:mm A");
    }

    public function getHtypeAttribute() {
        return ucfirst(str_replace('-', ' ', $this->type));
    }
}
