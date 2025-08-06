<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    // Bật timestamps (created_at, updated_at)
    public $timestamps = true;

    // Tùy chỉnh định dạng timestamp
    protected $dateFormat = 'Y-m-d H:i:s';
}
