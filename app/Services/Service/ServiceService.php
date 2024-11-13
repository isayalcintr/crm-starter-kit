<?php

namespace App\Services\Service;

use App\Models\Service\Service;
use App\Objects\Service\ServiceFilterObject;
use App\Objects\Service\ServiceObject;
use App\Repositories\Service\ServiceItemRepository;
use App\Repositories\Service\ServiceRepository;
use Illuminate\Support\Facades\DB;

class ServiceService
{
    protected ServiceRepository $serviceRepository;
    protected ServiceItemRepository $serviceItemRepository;

    public function __construct(ServiceRepository $serviceRepository, ServiceItemRepository $serviceItemRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->serviceItemRepository = $serviceItemRepository;
    }


    public function list(ServiceFilterObject $filter): \Illuminate\Database\Eloquent\Builder
    {
        $builder = $this->serviceRepository->services();
        if (!empty(trim($filter->getSearch())))
            $builder->where(DB::raw("
                    CONCAT_WS(' ', service.code, service.description,
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
            $builder->where('services.id', $filter->getId());
        return $builder;
    }

    public function store(ServiceObject $object)
    {
        return DB::transaction(function () use ($object) {
            $service = $this->serviceRepository->create($object);
            foreach ($object->getItems() as $item) {
                $this->serviceItemRepository->create($item->setServiceId($service->id));
            }
            return $service;
        });
    }

    public function update(ServiceObject $object)
    {
        return DB::transaction(function () use ($object) {
            $service = $this->serviceRepository->update($object);
            $this->clearItems($service);
            foreach ($object->getItems() as $item) {
                $this->serviceItemRepository->create($item->setServiceId($service->id));
            }
            return $object;
        });
    }

    public function destroy(ServiceObject $object)
    {
        return DB::transaction(function () use ($object) {
            $this->clearItems($object->getService());
            $this->serviceRepository->update($object->setTargetProperty("deleted_by"));
            return $this->serviceRepository->delete($object->getService());
        });
    }

    public function destroyItems(Service $service): bool
    {
        return DB::transaction(function () use ($service) {
            return $this->clearItems($service);
        });
    }

    public function clearItems(Service $service): bool
    {
        $items = $service->items;
        foreach ($items as $item) {
            $this->serviceItemRepository->delete($item);
        }
        return true;
    }
}
