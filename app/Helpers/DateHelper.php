<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper {

    public static function humans($date) {
        return (new Carbon($date))->diffForHumans();
    }

    public static function format($date, $format="dddd D MMM YYYY - H:mm A") {
        return (new Carbon($date))->isoFormat($format);
    }
}