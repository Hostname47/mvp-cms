<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\FileHelper;
use Carbon\Carbon;

class Metadata extends Model
{
    use HasFactory;

    protected $casts = [
        'data'=>'array'
    ];

    public function getFilepathAttribute() {
        return 'media-library/' . $this->data['name'];
    }

    public function getHumanSizeAttribute() {
        return FileHelper::human_readable_size($this->data['size']);
    }

    public function getHumanUploadDateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

}
