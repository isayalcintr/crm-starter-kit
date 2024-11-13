<?php

namespace App\Enums\Group;

enum SectionEnum : int
{
    case CUSTOMER = 1;
    case PRODUCT = 2;
    case INTERVIEW = 3;
    case TASK = 4;
    case SERVICE = 5;
    case OFFER = 6;

    public static function getLabel(int $value): string
    {
        return match ($value) {
            self::CUSTOMER->value => "Müşteri",
            self::PRODUCT->value => "Ürün",
            self::INTERVIEW->value => "Görüşme",
            self::TASK->value => "Görev",
            self::SERVICE->value => "Servis",
            self::OFFER->value => "Teklif",
            default => 'Bilinmiyor',
        };
    }

}
