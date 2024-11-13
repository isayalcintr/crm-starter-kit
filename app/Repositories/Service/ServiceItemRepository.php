<?php

namespace App\Repositories\Service;

use App\Models\Service\ServiceItem;
use App\Objects\Service\ServiceItemObject;

class ServiceItemRepository
{

    public function create(ServiceItemObject $object): ?ServiceItem
    {
        return ServiceItem::create($object->toArrayForSnakeCase());
    }

    public function delete(ServiceItem $item): ?bool
    {
        return $item->delete();
    }
}
