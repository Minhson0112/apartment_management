<?php

namespace App\Models;

class Apartment extends BaseModel
{
    protected $table = 'apartment';

    protected $fillable = [
        'apartment_name',
        'type',
        'area',
        'status',
        'check_in date',
        'check_out date',
        'apartment_owner',
        'appliances_price',
        'rent_price',
        'rent_start_time',
        'rent_end_time',
    ];

    // nếu table không có deleted_at, bạn có thể bỏ SoftDeletes hoặc thêm cột deleted_at vào migration

    // Quan hệ với Owner
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'apartment_owner', 'cccd');
    }

    // Các booking liên quan
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'apartment', 'id');
    }

    // Các gia hạn hợp đồng
    public function contractExtensions()
    {
        return $this->hasMany(ContractExtension::class, 'apartment', 'id');
    }

    // Các sử dụng sản phẩm
    public function useProducts()
    {
        return $this->hasMany(UseProduct::class, 'apartment', 'id');
    }

    // Ảnh apartment
    public function images()
    {
        return $this->hasMany(ApartmentImage::class, 'apartment', 'id');
    }
}
