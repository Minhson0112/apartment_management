<?php

namespace App\Enums;

enum ApartmentStatus: string
{
    case AVAILABLE = '1';
    case RESERVED = '2';
    case CHECKED_IN = '3';
    case NOT_AVAILABLE = '4';

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Trống',
            self::RESERVED => 'Đã nhận cọc',
            self::CHECKED_IN => 'Khách đang ở',
            self::NOT_AVAILABLE => 'Không khả dụng',
            default => '',
        };
    }
}
