<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    protected $fillable = [
        'quotation_id', 'product_id', 'quantity', 'unit_price', 'total_price', 'details'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
