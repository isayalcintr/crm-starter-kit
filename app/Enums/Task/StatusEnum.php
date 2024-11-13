<?php

namespace App\Enums\Task;

enum StatusEnum: int
{
    case PENDING = 0;
    case PROCESSING = 1;
    case COMPLETED = 2;
    case FAILED = 3;

    public static function getLabel(int $value): string
    {
        return match ($value) {
            self::PENDING->value => "Bekliyor",
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
            self::PENDING->value => '<span class="badge badge-outline badge-sm badge-warning">'. $label .'</span>',
            self::PROCESSING->value => '<span class="badge badge-sm badge-warning">'. $label .'</span>',
            self::COMPLETED->value => '<span class="badge badge-sm badge-success">'. $label .'</span>',
            self::FAILED->value => '<span class="badge badge-sm badge-danger">'. $label .'</span>',
            default => '<span class="badge badge-sm badge-info">'. $label .'</span>',
        };
    }


}
