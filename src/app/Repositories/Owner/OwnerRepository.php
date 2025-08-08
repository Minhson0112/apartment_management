<?php

namespace App\Repositories\Owner;

use App\Models\Owner;
use App\Repositories\Owner\OwnerRepositoryInterface;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class OwnerRepository extends BaseRepository implements OwnerRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return Owner::class;
    }

    #[\Override]
    public function queryAll(): Owner
    {
        return parent::queryAll();
    }
}
