<?php

namespace App\Enums\Offer;

enum StatusEnum: int
{
    case PROCESSING = 1;
    case ORDERED = 2;
    case REJECTED = 3;

    public static function getLabel(int $value): string
    {
        return match ($value) {
            self::PROCESSING->value => "İşlemde",
            self::ORDERED->value => "Sipariş",
            self::REJECTED->value => "İptal",
            default => 'Bilinmiyor',
        };
    }

    public static function getBadge(int $value): string
    {
        $label = self::getLabel($value);
        return match ($value) {
            self::PROCESSING->value => '<span class="badge badge-outline badge-sm badge-warning">'. $label .'</span>',
            self::ORDERED->value => '<span class="badge  badge-sm badge-success">'. $label .'</span>',
            self::REJECTED->value => '<span class="badge badge-sm badge-danger">'. $label .'</span>',
            default => '<span class="badge  badge-sm badge-info">'. $label .'</span>',
        };
    }
}
