<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'price'];

    public function details()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function quotationDetails()
    {
        return $this->hasMany(QuotationDetail::class);
    }
}
