<?php

namespace App\Repositories\Customer;

use App\Models\Customer\Customer;
use App\Objects\Customer\CustomerObject;
use Illuminate\Support\Facades\DB;

class CustomerRepository
{
    public function customers(): \Illuminate\Database\Eloquent\Builder
    {
        return Customer::with([
            'specialGroup1',
            'specialGroup2',
            'specialGroup3',
            'specialGroup4',
            'specialGroup5',
            'creator',
            'updater',
            'deleter'
        ]);
    }

    public function getCustomers(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->customers()->get();
    }

    public function create(CustomerObject $object): ?Customer
    {
        return Customer::create($object->toArrayForSnakeCase());
    }

    public function update(CustomerObject $object): ?Customer
    {
        return $this->updateWithArray($object->getCustomer(), $object->toArrayForSnakeCase());
    }

    public function updateWithArray(Customer $customer, array $data): ?Customer
    {
        $customer->update($data);
        return $customer;
    }

    public function delete(Customer $customer): ?bool
    {
        return $customer->delete();
    }

    public function customersWithSelect()
    {
        return Customer::select(DB::raw("CONCAT(code, '-', title) as text"), 'id as id');
    }
}
