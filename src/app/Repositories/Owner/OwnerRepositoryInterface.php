<?php

namespace App\Repositories\Owner;

use App\Models\Owner;

interface OwnerRepositoryInterface
{
    public function getModel(): string;

    public function queryAll(): Owner;
}
