<?php

// app/Models/Booking.php

namespace App\Models;

class Booking extends BaseModel
{
    protected $table = 'bookings';

    protected $fillable = [
        'customer',
        'apartment',
        'check_in_date',
        'check_out_date',
        'status',
        'price',
        'incidental_costs',
        'payment_status',
        'needer_bill',
        'note',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer', 'cccd');
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment', 'id');
    }
}
