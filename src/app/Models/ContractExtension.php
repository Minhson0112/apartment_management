<?php

namespace App\Models;

class ContractExtension extends BaseModel
{
    protected $table = 'contract_extension';

    protected $fillable = [
        'apartment',
        'expiration date',
        'date_of_extension',
        'rent_price',
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment', 'id');
    }
}
