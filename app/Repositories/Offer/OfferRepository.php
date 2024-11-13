<?php

namespace App\Repositories\Offer;

use App\Models\Offer\Offer;
use App\Objects\Offer\OfferObject;

class OfferRepository
{

    public function offers(): \Illuminate\Database\Eloquent\Builder
    {
        return Offer::with([
            'customer',
            'approvedBy',
            'cancelledBy',
            'creator',
            'updater',
            'deleter',
            'specialGroup1',
            'specialGroup2',
            'specialGroup3',
            'specialGroup4',
            'specialGroup5',
        ]);
    }

    public function create(OfferObject $object): Offer
    {
        return Offer::create($object->setIgnoredProperty('items')->toArrayForSnakeCase());
    }

    public function update(OfferObject $object): Offer
    {
        return $this->updateWithArray($object->getOffer(), $object->setIgnoredProperty('offer', 'items')->toArrayForSnakeCase());
    }

    public function updateWithArray(Offer $offer, array $data): Offer
    {
        $offer->update($data);
        return $offer;
    }

    public function delete(Offer $offer): ?bool
    {
        return $offer->delete();
    }
}
