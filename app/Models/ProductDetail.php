<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $fillable = ['product_id', 'detail_name', 'detail_value'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
