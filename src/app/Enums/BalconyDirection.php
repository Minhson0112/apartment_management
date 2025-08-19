<?php

namespace App\Enums;

enum BalconyDirection: string
{
    case EAST = '1';
    case WEST = '2';
    case SOUTH = '3';
    case NORTH = '4';
    case SOUTHEAST = '5';
    case NORTHWEST = '6';
    case SOUTHWEST = '7';
    case NORTHEAST = '8';

    public function label(): string
    {
        return match ($this) {
            self::EAST => 'Hướng đông',
            self::WEST => 'Hướng tây',
            self::SOUTH => 'Hướng nam',
            self::NORTH => 'Hướng bắc',
            self::SOUTHEAST => 'Hướng đông nam',
            self::NORTHWEST => 'Hướng tây bắc',
            self::SOUTHWEST => 'Hướng tây nam',
            self::NORTHEAST => 'Hướng đông bắc',
            default => '',
        };
    }
}
