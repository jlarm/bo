<?php

declare(strict_types=1);

namespace App\Enums;

enum Seasons: string
{
    case SPRING = 'spring';
    case SUMMER = 'summer';
    case FALL = 'fall';
    case WINTER = 'winter';

    public function label(): string
    {
        return match ($this) {
            self::SPRING => 'Spring',
            self::SUMMER => 'Summer',
            self::FALL => 'Fall',
            self::WINTER => 'Winter',
        };
    }

    public function iconName(): string
    {
        return match ($this) {
            self::SPRING => 'flower',
            self::SUMMER => 'sun',
            self::FALL => 'leaf',
            self::WINTER => 'snowflake',
        };
    }
}
