<?php

namespace App\Repositories\Base;

use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    public function getModel(): string;

    public function setModel(): void;

    public function all(): Collection;

}
