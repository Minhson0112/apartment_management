<?php

namespace App\Repositories\Base;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

interface BaseRepositoryInterface
{
    public function getModel(): string;

    public function setModel(): void;

    public function all(): Collection;

    public function queryAll(): Builder;

    public function create(array $obj): Model;

    public function createMany(array $rows): bool;

    public function deleteById(mixed $id): bool;
}
