<?php

namespace App\Enums\Group;

enum TypeEnum : int
{
    case CUSTOMER_SG1 = 100;
    case CUSTOMER_SG2 = 101;
    case CUSTOMER_SG3 = 102;
    case CUSTOMER_SG4 = 103;
    case CUSTOMER_SG5 = 104;

    case PRODUCT_SG1 = 200;
    case PRODUCT_SG2 = 201;
    case PRODUCT_SG3 = 202;
    case PRODUCT_SG4 = 203;
    case PRODUCT_SG5 = 204;

    case INTERVIEW_SG1 = 300;
    case INTERVIEW_SG2 = 301;
    case INTERVIEW_SG3 = 302;
    case INTERVIEW_SG4 = 303;
    case INTERVIEW_SG5 = 304;
    case INTERVIEW_CATEGORY = 305;
    case INTERVIEW_TYPE = 306;

    case TASK_SG1 = 400;
    case TASK_SG2 = 401;
    case TASK_SG3 = 402;
    case TASK_SG4 = 403;
    case TASK_SG5 = 404;
    case TASK_CATEGORY = 405;

    case SERVICE_SG1 = 500;
    case SERVICE_SG2 = 501;
    case SERVICE_SG3 = 502;
    case SERVICE_SG4 = 503;
    case SERVICE_SG5 = 504;

    case OFFER_SG1 = 600;
    case OFFER_SG2 = 601;
    case OFFER_SG3 = 602;
    case OFFER_SG4 = 603;
    case OFFER_SG5 = 604;

    public static function getLabel(int $value): string
    {
        return match ($value) {
            self::CUSTOMER_SG1->value => 'Özel Grup 1',
            self::CUSTOMER_SG2->value => 'Özel Grup 2',
            self::CUSTOMER_SG3->value => 'Özel Grup 3',
            self::CUSTOMER_SG4->value => 'Özel Grup 4',
            self::CUSTOMER_SG5->value => 'Özel Grup 5',

            self::PRODUCT_SG1->value => 'Özel Grup 1',
            self::PRODUCT_SG2->value => 'Özel Grup 2',
            self::PRODUCT_SG3->value => 'Özel Grup 3',
            self::PRODUCT_SG4->value => 'Özel Grup 4',
            self::PRODUCT_SG5->value => 'Özel Grup 5',

            self::INTERVIEW_SG1->value => 'Özel Grup 1',
            self::INTERVIEW_SG2->value => 'Özel Grup 2',
            self::INTERVIEW_SG3->value => 'Özel Grup 3',
            self::INTERVIEW_SG4->value => 'Özel Grup 4',
            self::INTERVIEW_SG5->value => 'Özel Grup 5',
            self::INTERVIEW_CATEGORY->value => 'Kategori',
            self::INTERVIEW_TYPE->value => 'Tip',

            self::TASK_SG1->value => 'Özel Grup 1',
            self::TASK_SG2->value => 'Özel Grup 2',
            self::TASK_SG3->value => 'Özel Grup 3',
            self::TASK_SG4->value => 'Özel Grup 4',
            self::TASK_SG5->value => 'Özel Grup 5',
            self::TASK_CATEGORY->value => 'Kategori',

            self::SERVICE_SG1->value => 'Özel Grup 1',
            self::SERVICE_SG2->value => 'Özel Grup 2',
            self::SERVICE_SG3->value => 'Özel Grup 3',
            self::SERVICE_SG4->value => 'Özel Grup 4',
            self::SERVICE_SG5->value => 'Özel Grup 5',

            self::OFFER_SG1->value => 'Özel Grup 1',
            self::OFFER_SG2->value => 'Özel Grup 2',
            self::OFFER_SG3->value => 'Özel Grup 3',
            self::OFFER_SG4->value => 'Özel Grup 4',
            self::OFFER_SG5->value => 'Özel Grup 5',
            default => 'Bilinmiyor',
        };
    }

    /**
     * @throws \Exception
     */
    public static function getSection(int $value): SectionEnum
    {
        if (in_array($value, [self::CUSTOMER_SG1->value, self::CUSTOMER_SG2->value, self::CUSTOMER_SG3->value, self::CUSTOMER_SG4->value, self::CUSTOMER_SG5->value], true))
            return SectionEnum::CUSTOMER;
        if (in_array($value, [self::PRODUCT_SG1->value, self::PRODUCT_SG2->value, self::PRODUCT_SG3->value, self::PRODUCT_SG4->value, self::PRODUCT_SG5->value], true))
            return SectionEnum::PRODUCT;
        if (in_array($value, [self::INTERVIEW_SG1->value, self::INTERVIEW_SG2->value, self::INTERVIEW_SG3->value, self::INTERVIEW_SG4->value, self::INTERVIEW_SG5->value, self::INTERVIEW_CATEGORY->value, self::INTERVIEW_TYPE->value], true))
            return SectionEnum::INTERVIEW;
        if (in_array($value, [self::TASK_SG1->value, self::TASK_SG2->value, self::TASK_SG3->value, self::TASK_SG4->value, self::TASK_SG5->value, self::TASK_CATEGORY->value], true))
            return SectionEnum::TASK;
        if (in_array($value, [self::SERVICE_SG1->value, self::SERVICE_SG2->value, self::SERVICE_SG3->value, self::SERVICE_SG4->value, self::SERVICE_SG5->value], true))
            return SectionEnum::SERVICE;
        if (in_array($value, [self::OFFER_SG1->value, self::OFFER_SG2->value, self::OFFER_SG3->value, self::OFFER_SG4->value, self::OFFER_SG5->value], true))
            return SectionEnum::OFFER;
        throw new \Exception('Group type section not found!');
    }

}
