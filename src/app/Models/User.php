<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Tên bảng
    protected $table = 'user';

    // Khóa chính
    protected $primaryKey = 'id';

    // Cho phép trường nào mass assign
    protected $fillable = [
        'full_name',
        'date_of_birth',
        'phone_number',
        'mail',
        'user_name',
        'password',
        'cccd',
        'role',
    ];

    // Ẩn khi toArray() / JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
