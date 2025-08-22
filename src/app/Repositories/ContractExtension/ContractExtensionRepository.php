<?php

namespace App\Repositories\ContractExtension;

use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContractExtension;
use Carbon\Carbon;

class ContractExtensionRepository extends BaseRepository implements ContractExtensionRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return ContractExtension::class;
    }

    #[\Override]
    public function create(array $obj): Model
    {
        return parent::create($obj);
    }

    #[\Override]
    public function queryAll(): Builder
    {
        return parent::queryAll();
    }

    public function findByApartmentId(string $apartmentId): Builder
    {
        return $this->queryAll()
            ->where('apartment', $apartmentId);
    }

    public function getMaxEndByApartment(string $apartmentId): ?Carbon
    {
        $max = $this->queryAll()
            ->where('apartment', $apartmentId)
            ->max('rent_end_time'); // trả về string|NULL

        return $max ? Carbon::parse($max) : null;
    }

}
