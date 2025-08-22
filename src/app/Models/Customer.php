<?php

namespace App\Models;

class Customer extends BaseModel
{
    protected $table = 'customers';
    protected $primaryKey = 'cccd';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'cccd',
        'full_name',
        'date_of_birth',
        'phone_number',
        'email',
        'note',
        'origin',
    ];

    // Quan hệ tới User (origin)
    public function originUser()
    {
        return $this->belongsTo(User::class, 'origin', 'cccd');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer', 'cccd');
    }

    public function images()
    {
        return $this->hasMany(CustomerImage::class, 'customer', 'cccd');
    }
}
