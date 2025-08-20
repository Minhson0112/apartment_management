<?php

namespace App\Repositories\Base;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
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

    public function queryAll(): Builder
    {
        return $this->model->newQuery();
    }

    public function create(array $obj): Model
    {
        return $this->model->newQuery()->create($obj);
    }

    public function createMany(array $rows): bool
    {
        if (empty($rows)) {
            return true;
        }

        if ($this->model->usesTimestamps()) {
            $now = Carbon::now();
            foreach ($rows as &$row) {
                $row['created_at'] = $row['created_at'] ?? $now;
                $row['updated_at'] = $row['updated_at'] ?? $now;
            }
            unset($row);
        }

        return $this->model->newQuery()->insert($rows);
    }

    public function deleteById(mixed $id): bool
    {
        return $this->model->newQuery()
            ->whereKey($id)
            ->delete() > 0;
    }

    public function findById(mixed $id): ?Model
    {
        return $this->model->newQuery()->find($id);
    }

    public function findByIdOrFail(mixed $id): Model
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function updateById(mixed $id, array $attributes): bool
    {
        return $this->model->newQuery()
            ->whereKey($id)
            ->update($attributes) > 0;
    }
}
