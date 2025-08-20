<?php

namespace App\Repositories\ContractExtension;

use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContractExtension;

class ContractExtensionRepository extends BaseRepository implements ContractExtensionRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return ContractExtension::class;
    }

    #[\Override]
    public function create(array $obj): Model
    {
        return parent::create($obj);
    }
}
