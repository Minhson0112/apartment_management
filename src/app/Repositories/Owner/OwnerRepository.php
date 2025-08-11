<?php

namespace App\Repositories\Owner;

use App\Models\Owner;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OwnerRepository extends BaseRepository implements OwnerRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return Owner::class;
    }

    #[\Override]
    public function queryAll(): Builder
    {
        return parent::queryAll();
    }

    #[\Override]
    public function create(array $obj): Model
    {
        return parent::create($obj);
    }

    public function search(array $filters): Builder
    {
        $query = $this->queryAll();

        if (!empty($filters['cccd'])) {
            $query->where('cccd', $filters['cccd']);
        }
        if (!empty($filters['full_name'])) {
            $query->where('full_name', 'like', '%'.$filters['full_name'].'%');
        }
        if (!empty($filters['apartment_name'])) {
            $name = $filters['apartment_name'];
            $query->whereHas('apartments', function ($q) use ($name) {
                $q->where('apartment_name', 'like', '%'.$name.'%');
            });
        }
        if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
            $query->whereBetween('date_of_birth', [$filters['date_from'], $filters['date_to']]);
        } else {
            if (!empty($filters['date_from'])) {
                $query->whereDate('date_of_birth', '>=', $filters['date_from']);
            }
            if (!empty($filters['date_to'])) {
                $query->whereDate('date_of_birth', '<=', $filters['date_to']);
            }
        }
        if (!empty($filters['mobile_number'])) {
            $query->where('mobile_number', 'like', '%'.$filters['mobile_number'].'%');
        }
        if (!empty($filters['email'])) {
            $query->where('email', 'like', '%'.$filters['email'].'%');
        }

        return $query;
    }

    public function findByCccd(string $cccd): Model
    {
        return $this->queryAll()
            ->where('cccd', $cccd)
            ->firstOrFail();
    }
}
