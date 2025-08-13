<?php

namespace App\Repositories\Apartment;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface ApartmentRepositoryInterface
{
    public function getModel(): string;

    public function queryAll(): Builder;

    public function getApartments(): Builder;

    public function create(array $obj): Model;

    public function search(array $filters): Builder;
}
