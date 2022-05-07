<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Carbon\Carbon;

class AuthorRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories($get='titles') {
        switch($get) {
            case 'titles':
                return Category::findMany(explode(',', $this->categories))->pluck('title');
                break;
            case 'all':
                return Category::findMany(explode(',', $this->categories));
                break;
        }
    }

    public function getDateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    public function getUpdateDateAttribute() {
        return (new Carbon($this->updated_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }
}
