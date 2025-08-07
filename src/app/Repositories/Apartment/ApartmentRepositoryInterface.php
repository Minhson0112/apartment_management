<?php

namespace App\Repositories\Apartment;

use Illuminate\Database\Eloquent\Builder;

interface ApartmentRepositoryInterface
{
    public function getModel(): string;

    public function queryForAdmin(): Builder;
}
