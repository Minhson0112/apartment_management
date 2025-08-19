<?php

namespace App\Repositories\Owner;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface OwnerRepositoryInterface
{
    public function getModel(): string;

    public function queryAll(): Builder;

    public function create(array $obj): Model;

    public function search(array $filters): Builder;

    public function findByCccd(string $cccd): Model;
}
