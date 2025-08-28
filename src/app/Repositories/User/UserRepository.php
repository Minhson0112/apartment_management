<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return User::class;
    }

    #[\Override]
    public function queryAll(): Builder
    {
        return parent::queryAll();
    }

    #[\Override]
    public function all(): Collection
    {
        return parent::all();
    }
}
