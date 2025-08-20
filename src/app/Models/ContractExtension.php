<?php

namespace App\Models;

class ContractExtension extends BaseModel
{
    protected $table = 'contract_extension';

    protected $fillable = [
        'apartment',
        'rent_start_time',
        'rent_end_time',
        'rent_price',
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment', 'id');
    }
}
