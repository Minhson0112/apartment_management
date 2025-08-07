<?php

namespace App\Models;

class OwnerImage extends BaseModel
{
    protected $table = 'owner_image';

    protected $fillable = [
        'owner',
        'image_file_name',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner', 'cccd');
    }
}
