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
}
