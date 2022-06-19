<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User,ContactMessage};
use Carbon\Carbon;

class ContactMessage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getDateHumansAttribute() {
        return (new Carbon($this->created_at))->diffForHumans();
    }

    public function getDateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    public function slice($length) {
        $message = $this->message;
        return strlen($message) <= $length ? $message : substr($message, 0, $length) . '..';
    }

    public static function unread_messages_count() {
        return ContactMessage::where('read', 0)->count();
    }
}
