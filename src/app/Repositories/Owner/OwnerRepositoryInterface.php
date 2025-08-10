<?php

namespace App\Repositories\Owner;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Owner\SearchOwnerRequest;
use Illuminate\Database\Eloquent\Model;

use App\Models\Owner;

interface OwnerRepositoryInterface
{
    public function getModel(): string;

    public function queryAll(): Builder;

    public function create(array $obj): Model;

    public function search(array $filters): Builder;
}
