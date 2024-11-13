<?php

namespace App\Enums\Task;

enum PriorityEnum: int
{
    case HIGH = 1;
    case NORMAL = 2;
    case LOW = 3;

    public static function getLabel(int $value): string
    {
        return match ($value) {
            self::HIGH->value => "Yüksek",
            self::NORMAL->value => "Normal",
            self::LOW->value => "Düşük",
            default => 'Bilinmiyor',
        };
    }

    public static function getBadge(int $value): string
    {
        $label = self::getLabel($value);
        return match ($value) {
            self::HIGH->value => '<span class="badge badge-sm badge-danger">'. $label .'</span>',
            self::NORMAL->value => '<span class="badge badge-sm badge-primary">'. $label .'</span>',
            self::LOW->value => '<span class="badge badge-sm badge-info">'. $label .'</span>',
            default => '<span class="badge badge-sm badge-info">'. $label .'</span>',
        };
    }
}
