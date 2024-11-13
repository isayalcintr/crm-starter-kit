<?php

namespace App\Enums\Offer;

enum StageEnum: int
{
    case OFFER = 1;
    case APPROVAL = 2;
    case CUSTOMER_APPROVAL = 3;
    case ORDER = 4;

    public static function getLabel(int $value): string
    {
        return match ($value) {
            self::OFFER->value => "Teklif",
            self::APPROVAL->value => "Onay",
            self::CUSTOMER_APPROVAL->value => "Müşteri Onay",
            self::ORDER->value => "Sipariş",
            default => 'Bilinmiyor',
        };
    }

    public static function getBadge(int $value): string
    {
        $label = self::getLabel($value);
        return match ($value) {
            self::OFFER->value => '<span class="badge badge-outline badge-sm badge-info">'. $label .'</span>',
            self::APPROVAL->value => '<span class="badge  badge-sm badge-warning">'. $label .'</span>',
            self::CUSTOMER_APPROVAL->value => '<span class="badge badge-sm badge-primary">'. $label .'</span>',
            self::ORDER->value => '<span class="badge badge-sm badge-success">'. $label .'</span>',
            default => '<span class="badge  badge-sm badge-info">'. $label .'</span>',
        };
    }
}
