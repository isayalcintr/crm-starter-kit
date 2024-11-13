<?php

namespace App\Services\Offer;

use App\Enums\Offer\StageEnum;
use App\Enums\Offer\StatusEnum;
use App\Models\Offer\Offer;
use App\Objects\Offer\OfferFilterObject;
use App\Objects\Offer\OfferObject;
use App\Objects\Service\ServiceObject;
use App\Repositories\Offer\OfferItemRepository;
use App\Repositories\Offer\OfferRepository;
use Illuminate\Support\Facades\DB;

class OfferService
{
    protected OfferRepository $offerRepository;
    protected OfferItemRepository $offerItemRepository;

    public function __construct(OfferRepository $offerRepository, OfferItemRepository $offerItemRepository)
    {
        $this->offerRepository = $offerRepository;
        $this->offerItemRepository = $offerItemRepository;
    }

    public function list(OfferFilterObject $filter): \Illuminate\Database\Eloquent\Builder
    {
        $builder = $this->offerRepository->offers();
        if (!empty(trim($filter->getSearch())))
            $builder->where(DB::raw("
                    CONCAT_WS(' ', offer.code, offer.description,
                        IFNULL(customer.name, ''),
                        IFNULL(customer.code, ''),
                        IFNULL(special_group1.name, ''),
                        IFNULL(special_group2.name, ''),
                        IFNULL(special_group3.name, ''),
                        IFNULL(special_group4.name, ''),
                        IFNULL(special_group5.name, '')
                    )
                "), 'LIKE', "%".trim($filter->getSearch())."%");
        if ($filter->getId() > 0)
            $builder->where('offers.id', $filter->getId());
        return $builder;
    }

    public function store(OfferObject $object)
    {
        return DB::transaction(function () use ($object) {
            $offer = $this->offerRepository->create($object);
            foreach ($object->getItems() as $item) {
                $this->offerItemRepository->create($item->setOfferId($offer->id));
            }
            return $offer;
        });
    }

    public function update(OfferObject $object)
    {
        return DB::transaction(function () use ($object) {
            $offer = $this->offerRepository->update($object);
            $this->clearItems($offer);
            foreach ($object->getItems() as $item) {
                $this->offerItemRepository->create($item->setOfferId($offer->id));
            }
            return $object;
        });
    }

    public function destroy(OfferObject $object)
    {
        return DB::transaction(function () use ($object) {
            $this->clearItems($object->getOffer());
            $this->offerRepository->update($object->setTargetProperty("deleted_by"));
            return $this->offerRepository->delete($object->getOffer());
        });
    }

    public function destroyItems(Offer $offer): bool
    {
        return DB::transaction(function () use ($offer) {
            return $this->clearItems($offer);
        });
    }

    public function clearItems(Offer $offer): bool
    {
        $items = $offer->getAttribute('items') ?? [];
        foreach ($items as $item) {
            $this->offerItemRepository->delete($item);
        }
        return true;
    }

    public function cancel(OfferObject $object)
    {
        return DB::transaction(function () use ($object) {
            $offer = $this->offerRepository->update($object->setTargetProperties('status', 'cancelled_by', 'cancelled_date'));
            $object->setOffer($offer);
            return $object;
        });
    }

    public function changeStage(OfferObject $object): OfferObject
    {
        return DB::transaction(function () use ($object) {
            $object->setTargetProperties('stage');
            if ($object->getStage() == StageEnum::CUSTOMER_APPROVAL){
                $object->setTargetProperty('approved_by', 'approved_date');
            }
            else if ($object->getStage() == StageEnum::ORDER->value){
                $object->setStatus(StatusEnum::ORDERED->value)->setTargetProperty('status');
            }
            $offer = $this->offerRepository->update($object);
            $object->setOffer($offer);
            return $object;
        });
    }
}
