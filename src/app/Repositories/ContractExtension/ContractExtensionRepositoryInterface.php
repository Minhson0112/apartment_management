<?php

namespace App\Repositories\ContractExtension;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface ContractExtensionRepositoryInterface
{
    public function getModel(): string;

    public function create(array $obj): Model;

}
