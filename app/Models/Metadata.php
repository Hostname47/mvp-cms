<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    use HasFactory;

    protected $casts = [
        'data'=>'array'
    ];

    public function getFilepathAttribute() {
        return 'media-library/' . $this->data['name'];
    }
}
