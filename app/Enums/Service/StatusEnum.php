<?php

namespace App\Enums\Service;

enum StatusEnum: int
{
    case PROCESSING = 0;
    case COMPLETED = 1;
    case FAILED = 2;

    public static function getLabel(int $value): string
    {
        return match ($value) {
            self::PROCESSING->value => "İşlemde",
            self::COMPLETED->value => "Tamamlandı",
            self::FAILED->value => "İptal",
            default => 'Bilinmiyor',
        };
    }

    public static function getBadge(int $value): string
    {
        $label = self::getLabel($value);
        return match ($value) {
            self::PROCESSING->value => '<span class="badge badge-outline badge-sm badge-warning">'. $label .'</span>',
            self::COMPLETED->value => '<span class="badge  badge-sm badge-success">'. $label .'</span>',
            self::FAILED->value => '<span class="badge badge-sm badge-danger">'. $label .'</span>',
            default => '<span class="badge  badge-sm badge-info">'. $label .'</span>',
        };
    }
}
