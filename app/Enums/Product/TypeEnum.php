<?php

namespace App\Enums\Product;

enum TypeEnum: int
{
    case PRODUCT = 1;
    case SERVICE = 2;

    public static function getLabel(int $value): string
    {
        return match ($value) {
            self::PRODUCT->value => "Ürün",
            self::SERVICE->value => "Hizmet",
            default => 'Bilinmiyor',
        };
    }

    public static function getBadge(int $value): string
    {
        $label = self::getLabel($value);
        return match ($value) {
            self::PRODUCT->value => '<span class="badge badge-sm">'. $label .'</span>',
            self::SERVICE->value => '<span class="badge badge-sm badge-dark">'. $label .'</span>',
            default => '<span class="badge badge-sm badge-info">'. $label .'</span>',
        };
    }


}
