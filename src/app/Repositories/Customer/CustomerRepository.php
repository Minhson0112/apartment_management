<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return Customer::class;
    }

    #[\Override]
    public function queryAll(): Builder
    {
        return parent::queryAll()->with([
            'user' => fn ($q) => $q->select('cccd', 'full_name'),
        ]);
    }
}
