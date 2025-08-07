<?php

namespace App\Repositories\Base;

use Exception;
use Illuminate\Support\Collection;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Get model
     * @return string
     */
    public function getModel(): string
    {
        throw new Exception('Method getModel is not override');
    }

    /**
     * Set model
     * @return void
     */
    public function setModel(): void
    {
        $this->model = app()->make($this->getModel());
    }

    /**
     * Lấy tất cả bản ghi (SELECT * FROM table)
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }
}
