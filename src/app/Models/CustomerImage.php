<?php

namespace App\Models;

class CustomerImage extends BaseModel
{
    protected $table = 'customers_image';

    protected $fillable = [
        'customer',
        'image_file_name',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer', 'cccd');
    }
}
