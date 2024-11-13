<?php

namespace App\Services\Customer;

use App\Objects\Customer\CustomerFilterObject;
use App\Objects\Customer\CustomerObject;
use App\Repositories\Customer\CustomerRepository;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    protected CustomerRepository $customerRepository;
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function list(CustomerFilterObject $filter)
    {
        $builder = $this->customerRepository->customers();
        if (!empty(trim($filter->getSearch())))
            $builder->where(DB::raw("
                    CONCAT_WS(' ', customers.code, customers.name,
                        IFNULL(special_group1.name, ''),
                        IFNULL(special_group2.name, ''),
                        IFNULL(special_group3.name, ''),
                        IFNULL(special_group4.name, ''),
                        IFNULL(special_group5.name, '')
                    )
                "), 'LIKE', "%".trim($filter->getSearch())."%");
        return $builder;
    }

    public function store(CustomerObject $object)
    {
        return DB::transaction(function () use ($object) {
            return $this->customerRepository->create($object);
        });
    }

    public function update(CustomerObject $object)
    {
        return DB::transaction(function () use ($object) {
            $customer = $this->customerRepository->update($object);
            return $customer;
        });
    }

    public function destroy(CustomerObject $object)
    {
        return DB::transaction(function () use ($object) {
            $this->customerRepository->update($object->setTargetProperty("deleted_by"));
            return $this->customerRepository->delete($object->getCustomer());
        });
    }

    public function select(CustomerFilterObject $filter)
    {
        $builder = $this->customerRepository->customersWithSelect();
        return $builder;
    }

}
