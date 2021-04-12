<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query) {
            $query->invoice_number = "INV-" . date("Y") . generateRandomString(1,true)
             . generateRandomString(4). (self::count() + 1 ) ;

        });
        
    }

    public function invoice_items()
    {
        return $this->hasMany("\App\Models\InvoiceItem","invoice_id","id");
    }

    public function customer()
    {
        return $this->belongsTo("\App\Models\Customer","customer_id","id")->withDefault();
    }
}
