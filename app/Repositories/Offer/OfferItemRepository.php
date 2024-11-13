<?php

namespace App\Repositories\Offer;

use App\Models\Offer\OfferItem;
use App\Objects\Offer\OfferItemObject;

class OfferItemRepository
{

    public function create(OfferItemObject $object): OfferItem
    {
        return OfferItem::create($object->toArrayForSnakeCase());
    }

    public function delete(OfferItem $offerItem): ?bool
    {
        return $offerItem->delete();
    }
}
