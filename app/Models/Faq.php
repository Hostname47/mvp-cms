<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

class Faq extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class)->withoutGlobalScopes();
    }

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }
    
    public function getQuestionsliceAttribute() {
        return strlen($this->question) > 20 ? substr($this->question, 0, 20) . '..' : $this->question;
    }
    
    public function getDateHumansAttribute() {
        return (new Carbon($this->created_at))->diffForHumans();
    }

    public function getDateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    public static function unverified_count() {
        return Faq::where('live', 0)->count();
    }
}
