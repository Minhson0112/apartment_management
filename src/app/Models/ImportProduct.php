<?php

// app/Models/ImportProduct.php

namespace App\Models;

class ImportProduct extends BaseModel
{
    protected $table = 'import_product';

    protected $fillable = [
        'product',
        'supplier',
        'quantity',
        'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier', 'id');
    }
}
