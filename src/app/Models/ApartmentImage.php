<?php

namespace App\Models;

class ApartmentImage extends BaseModel
{
    protected $table = 'apartment_image';

    protected $fillable = [
        'apartment',
        'image_file_name',
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment', 'id');
    }
}
