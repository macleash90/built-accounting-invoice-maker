<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
class Item extends Model
{
    use SoftDeletes;
    public function getItemImgAttribute($value)
    {
        return URL::route('index') . '/' . $value;
    }
}
