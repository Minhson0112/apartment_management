<?php

namespace App\Repositories\CustomerImage;

use App\Models\CustomerImage;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CustomerImageRepository extends BaseRepository implements CustomerImageRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return CustomerImage::class;
    }

    #[\Override]
    public function createMany(array $rows): bool
    {
        return parent::createMany($rows);
    }

    #[\Override]
    public function queryAll(): Builder
    {
        return parent::queryAll();
    }
}
