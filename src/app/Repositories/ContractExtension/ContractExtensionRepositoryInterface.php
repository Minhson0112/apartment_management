<?php

namespace App\Repositories\ContractExtension;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

interface ContractExtensionRepositoryInterface
{
    public function getModel(): string;

    public function create(array $obj): Model;

    public function queryAll(): Builder;

    public function findByApartmentId(string $apartmentId): Builder;

    public function getMaxEndByApartment(string $apartmentId): ?Carbon;
}
