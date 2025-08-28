<?php

namespace App\Repositories\CustomerImage;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CustomerImageRepositoryInterface
{
    public function getModel(): string;

    public function createMany(array $rows): bool;

    public function queryAll(): Builder;
}
