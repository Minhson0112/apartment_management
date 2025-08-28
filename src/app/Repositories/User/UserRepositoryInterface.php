<?php

namespace App\Repositories\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function getModel(): string;

    public function queryAll(): Builder;

    public function all(): Collection;
}
