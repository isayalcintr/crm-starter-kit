<?php

namespace App\Objects\Customer;

use App\Models\Customer\Customer;
use App\Objects\BaseObject;

class CustomerObject extends BaseObject
{
    protected ?Customer $customer = null;
    protected ?string $code = null;
    protected ?string $title = null;
    protected ?string $email = null;
    protected ?string $phone1 = null;
    protected ?string $city = null;
    protected ?string $state = null;
    protected ?string $address1 = null;
    protected ?string $address2 = null;
    protected ?string $taxNumber = null;
    protected ?string $taxOffice = null;
    protected ?int $specialGroup1Id = null;
    protected ?int $specialGroup2Id = null;
    protected ?int $specialGroup3Id = null;
    protected ?int $specialGroup4Id = null;
    protected ?int $specialGroup5Id = null;
    protected ?int $type = null;
    protected ?int $createdBy = null;
    protected ?int $updatedBy = null;
    protected ?int $deletedBy = null;

    public function __construct(?Customer $customer = null, ?string $code = null, ?string $title = null, ?string $email = null, ?string $phone1 = null, ?string $city = null, ?string $state = null, ?string $address1 = null, ?string $address2 = null, ?string $taxNumber = null, ?string $taxOffice = null, ?int $specialGroup1Id = null, ?int $specialGroup2Id = null, ?int $specialGroup3Id = null, ?int $specialGroup4Id = null, ?int $specialGroup5Id = null, ?int $type = null, ?int $createdBy = null, ?int $updatedBy = null, ?int $deletedBy = null)
    {
        $this->setCustomer($customer);
        $this->setCode($code);
        $this->setTitle($title);
        $this->setEmail($email);
        $this->setPhone1($phone1);
        $this->setCity($city);
        $this->setState($state);
        $this->setAddress1($address1);
        $this->setAddress2($address2);
        $this->setTaxNumber($taxNumber);
        $this->setTaxOffice($taxOffice);
        $this->setSpecialGroup1Id($specialGroup1Id);
        $this->setSpecialGroup2Id($specialGroup2Id);
        $this->setSpecialGroup3Id($specialGroup3Id);
        $this->setSpecialGroup4Id($specialGroup4Id);
        $this->setSpecialGroup5Id($specialGroup5Id);
        $this->setType($type);
        $this->setCreatedBy($createdBy);
        $this->setUpdatedBy($updatedBy);
        $this->setDeletedBy($deletedBy);
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;
        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone1(): ?string
    {
        return $this->phone1;
    }

    public function setPhone1(?string $phone1): self
    {
        $this->phone1 = $phone1;
        return $this;
    }

    // City
    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;
        return $this;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(?string $address1): self
    {
        $this->address1 = $address1;
        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): self
    {
        $this->address2 = $address2;
        return $this;
    }

    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(?string $taxNumber): self
    {
        $this->taxNumber = $taxNumber;
        return $this;
    }

    // TaxOffice
    public function getTaxOffice(): ?string
    {
        return $this->taxOffice;
    }

    public function setTaxOffice(?string $taxOffice): self
    {
        $this->taxOffice = $taxOffice;
        return $this;
    }

    public function getSpecialGroup1Id(): ?int
    {
        return $this->specialGroup1Id;
    }

    public function setSpecialGroup1Id(?int $specialGroup1Id): self
    {
        $this->specialGroup1Id = $specialGroup1Id;
        return $this;
    }

    public function getSpecialGroup2Id(): ?int
    {
        return $this->specialGroup2Id;
    }

    public function setSpecialGroup2Id(?int $specialGroup2Id): self
    {
        $this->specialGroup2Id = $specialGroup2Id;
        return $this;
    }

    public function getSpecialGroup3Id(): ?int
    {
        return $this->specialGroup3Id;
    }

    public function setSpecialGroup3Id(?int $specialGroup3Id): self
    {
        $this->specialGroup3Id = $specialGroup3Id;
        return $this;
    }

    public function getSpecialGroup4Id(): ?int
    {
        return $this->specialGroup4Id;
    }

    public function setSpecialGroup4Id(?int $specialGroup4Id): self
    {
        $this->specialGroup4Id = $specialGroup4Id;
        return $this;
    }

    public function getSpecialGroup5Id(): ?int
    {
        return $this->specialGroup5Id;
    }

    public function setSpecialGroup5Id(?int $specialGroup5Id): self
    {
        $this->specialGroup5Id = $specialGroup5Id;
        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?int $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?int $updatedBy): self
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    public function getDeletedBy(): ?int
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(?int $deletedBy): self
    {
        $this->deletedBy = $deletedBy;
        return $this;
    }

}
