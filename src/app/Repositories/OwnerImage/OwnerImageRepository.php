<?php

namespace App\Repositories\OwnerImage;

use App\Models\OwnerImage;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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

    #[\Override]
    public function queryAll(): Builder
    {
        return parent::queryAll();
    }

    public function getImages(string $cccd): Collection
    {
        return $this->queryAll()
        ->where('owner', $cccd)
        ->orderByDesc('created_at')
        ->get();
    }

    public function findByIdAndCccd(int $imageId, string $cccd): Model
    {
        return $this->queryAll()
            ->where('id', $imageId)
            ->where('owner', $cccd)
            ->firstOrFail();
    }
}
