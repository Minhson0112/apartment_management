<?php

namespace App\Models;

class Owner extends BaseModel
{
    protected $table = 'owner';
    protected $primaryKey = 'cccd';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'cccd',
        'full_name',
        'date_of_birth',
        'mobile_number',
        'email',
    ];

    public function apartments()
    {
        return $this->hasMany(Apartment::class, 'apartment_owner', 'cccd');
    }

    public function images()
    {
        return $this->hasMany(OwnerImage::class, 'owner', 'cccd');
    }
}
