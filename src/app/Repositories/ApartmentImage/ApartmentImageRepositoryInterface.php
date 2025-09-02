<?php

namespace App\Repositories\ApartmentImage;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ApartmentImageRepositoryInterface
{
    public function getModel(): string;

    public function createMany(array $rows): bool;

    public function queryAll(): Builder;

    public function getImages(string $id): Collection;

    public function findByIdAndApartmentId(int $imageId, string $apartmentId): Model;

    
}
