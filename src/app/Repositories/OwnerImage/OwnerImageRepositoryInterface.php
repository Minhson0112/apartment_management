<?php

namespace App\Repositories\OwnerImage;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface OwnerImageRepositoryInterface
{
    public function getModel(): string;

    public function createMany(array $rows): bool;

    public function queryAll(): Builder;

    public function getImages(string $cccd): Collection;

    public function findByIdAndCccd(int $imageId, string $cccd): Model;
}
