<?php

namespace App\Repositories\Service;

use App\Models\Service\Service;
use App\Objects\Service\ServiceObject;

class ServiceRepository
{

    public function create(ServiceObject $object): ?Service
    {
        return Service::create($object->toArrayForSnakeCase());
    }

    public function services(): \Illuminate\Database\Eloquent\Builder
    {
        return Service::with([
            'customer',
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

    public function getServices(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->services()->get();
    }

    public function delete(Service $service): ?bool
    {
        return $service->delete();
    }

    public function update(ServiceObject $object): ?Service
    {
        return $this->updateWithArray($object->getService(), $object->toArrayForSnakeCase());
    }

    public function updateWithArray(Service $service, array $data): ?Service
    {
        $service->update($data);
        return $service;
    }
}
