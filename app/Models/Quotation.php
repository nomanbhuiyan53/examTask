<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function quotationDetails()
    {
        return $this->hasMany(QuotationDetail::class);
    }
}
