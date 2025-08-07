<?php

namespace App\Models;

class Product extends BaseModel
{
    protected $table = 'product';

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'supplier',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier', 'id');
    }

    public function importProducts()
    {
        return $this->hasMany(ImportProduct::class, 'product', 'id');
    }

    public function useProducts()
    {
        return $this->hasMany(UseProduct::class, 'product', 'id');
    }
}
