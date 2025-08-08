<?php

namespace App\Repositories\Apartment;

use App\Models\Apartment;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class ApartmentRepository extends BaseRepository implements ApartmentRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return Apartment::class;
    }

    public function queryForAdmin(): Builder
    {
        return $this->model
            ->select([
                'id',
                'apartment_name',
                'type',
                'area',
                'status',
                'check_in_date',
                'check_out_date',
            ]);
    }
}
