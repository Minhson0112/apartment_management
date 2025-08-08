<?php

namespace App\Repositories\OwnerImage;


interface OwnerImageRepositoryInterface
{
    public function getModel(): string;

    public function createMany(array $rows): bool;
}
