<?php

namespace App\Repositories\OwnerImage;

use App\Models\OwnerImage;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class OwnerImageRepository extends BaseRepository implements OwnerImageRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return OwnerImage::class;
    }

    #[\Override]
    public function createMany(array $rows): bool
    {
        return parent::createMany($rows);
    }
}
