<?php

namespace App\Helpers;

class ImageHelper {

    public static function is_image($mime) {
        return substr($mime, 0, 5) == 'image';
    }
}