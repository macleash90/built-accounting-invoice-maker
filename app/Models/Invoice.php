<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query) {
            $query->invoice_number = "INV-" . date("Y") . generateRandomString(1,true)
             . generateRandomString(4). (self::count() + 1 ) ;

        });
        
    }
}
