<?php

namespace App\Repositories\ApartmentImage;

use App\Models\ApartmentImage;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
class ApartmentImageRepository extends BaseRepository implements ApartmentImageRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return ApartmentImage::class;
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

    public function getImages(string $id): Collection
    {
        return $this->queryAll()
            ->where('apartment', $id)
            ->orderByDesc('created_at')
            ->get();
    }
    public function findByIdAndApartmentId(int $imageId, string $apartmentId): Model
    {
        return $this->queryAll()
            ->where('id', $imageId)
            ->where('apartment', $apartmentId)
            ->firstOrFail();
    }


}
