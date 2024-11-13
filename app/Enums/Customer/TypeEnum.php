<?php

namespace App\Enums\Customer;

enum TypeEnum: int
{
    case BUYER = 1;
    case SELLER = 2;
    case BUYERANDSELLER = 3;

    public static function getLabel(int $value): string
    {
        return match ($value) {
            self::BUYER->value => "Alıcı",
            self::SELLER->value => "Satıcı",
            self::BUYERANDSELLER->value => "Alıcı + Satıcı",
            default => 'Bilinmiyor',
        };
    }

    public static function getBadge(int $value): string
    {
        $label = self::getLabel($value);
        return match ($value) {
            self::BUYER->value => '<span class="badge badge-sm badge-success">'. $label .'</span>',
            self::SELLER->value => '<span class="badge badge-sm badge-warning">'. $label .'</span>',
            self::BUYERANDSELLER->value => '<span class="badge badge-sm badge-primary">'. $label .'</span>',
            default => '<span class="badge badge-sm badge-info">'. $label .'</span>',
        };
    }
}
