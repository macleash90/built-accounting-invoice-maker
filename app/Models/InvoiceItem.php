<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    use SoftDeletes;
    protected $table = "invoice_item";
    public function item()
    {
        return $this->belongsTo("App\Models\Item")->withDefault();
    }
}
