<?php

namespace App\Models;

class UseProduct extends BaseModel
{
    protected $table = 'use_product';

    protected $fillable = [
        'apartment',
        'product',
        'quantity',
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product', 'id');
    }
}
