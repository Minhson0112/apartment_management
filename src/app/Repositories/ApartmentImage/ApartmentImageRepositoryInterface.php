<?php

namespace App\Repositories\ApartmentImage;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface ApartmentImageRepositoryInterface
{
    public function getModel(): string;

    public function createMany(array $rows): bool;

    public function queryAll(): Builder;

    public function getImages(string $id): Collection;
}
