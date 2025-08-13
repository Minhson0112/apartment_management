<?php

namespace App\Enums;

enum ApartmentType: string
{
    case ONE_BEDROOM = '1';
    case TWO_BEDROOM = '2';
    case THREE_BEDROOM = '3';
    case FOUR_BEDROOM = '4';

    public function label(): string
    {
        return match ($this) {
            self::ONE_BEDROOM => 'Một phòng ngủ',
            self::TWO_BEDROOM => 'Hai phòng ngủ',
            self::THREE_BEDROOM => 'Ba phòng ngủ',
            self::FOUR_BEDROOM => 'Bốn phòng ngủ',
            default => '',
        };
    }
}

