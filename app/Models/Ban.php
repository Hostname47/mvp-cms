<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ban extends Model
{
    use HasFactory;

    public function banner() {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function reason() {
        return $this->belongsTo(BanReason::class, 'ban_reason');
    }

    public function getTypeAttribute() {
        return ($this->ban_duration == -1) ? 'permanent' : 'temporary';
    }

    public function getBandateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    public function getBanDurationHummansAttribute() {
        $bandate = $this->created_at->timestamp;
        $deadline = $this->created_at->addDays($this->ban_duration)->timestamp;
        $duration = $deadline - $bandate;

        $months = floor($duration/2592000);
        $days = floor(($duration%2592000)/86400);
        $hours = floor(($duration%86400)/3600);
        
        $duration = "";
        if($months) 
            $duration .= $months . ' ' . __('months') . ' ';
        if($days) {
            if($months) $duration .= __('and') . ' ';
            $duration .= $days . ' ' . __('days') . ' ';
        }
        if($hours) {
            if($days) $duration .= __('and') . ' ';
            $duration .= $hours . ' ' . __('hours');
        }

        return trim($duration);
    }

    public function getExpiredatAttribute() {
        return (new Carbon($this->created_at))->addDays($this->ban_duration)->isoFormat("dddd D MMM YYYY - H:mm A");
    }
}
