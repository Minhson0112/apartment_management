<?php

namespace App\Repositories\Customer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface CustomerRepositoryInterface
{
    public function getModel(): string;

    public function queryAll(): Builder;
}
