<?php

namespace App\Models;

class Supplier extends BaseModel
{
    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'phone_number',
        'email',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'supplier', 'id');
    }

    public function importProducts()
    {
        return $this->hasMany(ImportProduct::class, 'supplier', 'id');
    }
}
