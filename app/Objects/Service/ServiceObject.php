<?php

namespace App\Objects\Service;


use App\Models\Service\Service;
use App\Objects\BaseObject;

class ServiceObject extends BaseObject
{
    protected ?Service $service = null;
    protected ?int $id = null;
    protected ?int $customerId = null;
    protected ?string $description = null;
    protected ?string $startDate = null;
    protected ?string $endDate = null;
    protected ?string $status = null;
    protected ?float $serviceTotal = null;
    protected ?float $stockTotal = null;
    protected ?float $subTotal = null;
    protected ?float $vatTotal = null;
    protected ?float $total = null;
    /**
     * @var ServiceItemObject[]|null
     */
    protected ?array $items = [];
    protected ?int $specialGroup1 = null;
    protected ?int $specialGroup2 = null;
    protected ?int $specialGroup3 = null;
    protected ?int $specialGroup4 = null;
    protected ?int $specialGroup5 = null;
    protected ?int $createdBy = null;
    protected ?int $updatedBy = null;
    protected ?int $deletedBy = null;

    public function __construct(?Service $service = null, ?int $id = null, ?int $customerId = null, ?string $description = null, ?string $startDate = null, ?string $endDate = null, ?string $status = null, ?float $stockTotal =  null, ?float $serviceTotal = null, ?float $subTotal = null, ?float $vatTotal = null, ?float $total = null, ?array $items = [], ?int $specialGroup1 = null, ?int $specialGroup2 = null, ?int $specialGroup3 = null, ?int $specialGroup4 = null, ?int $specialGroup5 = null, ?int $createdBy = null, ?int $updatedBy = null, ?int $deletedBy = null)
    {
        $this->setService($service);
        $this->setId($id);
        $this->setCustomerId($customerId);
        $this->setDescription($description);
        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
        $this->setStatus($status);
        $this->setStockTotal($stockTotal);
        $this->setServiceTotal($serviceTotal);
        $this->setSubTotal($subTotal);
        $this->setVatTotal($vatTotal);
        $this->setTotal($total);
        $this->setItems($items);
        $this->setSpecialGroup1($specialGroup1);
        $this->setSpecialGroup2($specialGroup2);
        $this->setSpecialGroup3($specialGroup3);
        $this->setSpecialGroup4($specialGroup4);
        $this->setSpecialGroup5($specialGroup5);
        $this->setCreatedBy($createdBy);
        $this->setUpdatedBy($updatedBy);
        $this->setDeletedBy($deletedBy);
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    public function setCustomerId(?int $customerId): self
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(?string $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getServiceTotal(): ?float
    {
        return $this->serviceTotal;
    }

    public function setServiceTotal(?float $serviceTotal): self
    {
        $this->serviceTotal = $serviceTotal;
        return $this;
    }

    public function getStockTotal(): ?float
    {
        return $this->stockTotal;
    }

    public function setStockTotal(?float $stockTotal): self
    {
        $this->stockTotal = $stockTotal;
        return $this;
    }

    public function getSubTotal(): ?float
    {
        return $this->subTotal;
    }

    public function setSubTotal(?float $subTotal): self
    {
        $this->subTotal = $subTotal;
        return $this;
    }

    public function getVatTotal(): ?float
    {
        return $this->vatTotal;
    }

    public function setVatTotal(?float $vatTotal): self
    {
        $this->vatTotal = $vatTotal;
        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;
        return $this;
    }

    public function getItems(): ?array
    {
        return $this->items;
    }

    public function setItems(?array $items): self
    {
        $this->items = array_map(function (array $item) {
            return (new ServiceItemObject())->initFromArray($item);
        }, $items ?? []);
        return $this;
    }

    public function getSpecialGroup1(): ?int
    {
        return $this->specialGroup1;
    }

    public function setSpecialGroup1(?int $specialGroup1): self
    {
        $this->specialGroup1 = $specialGroup1;
        return $this;
    }

    public function getSpecialGroup2(): ?int
    {
        return $this->specialGroup2;
    }

    public function setSpecialGroup2(?int $specialGroup2): self
    {
        $this->specialGroup2 = $specialGroup2;
        return $this;
    }

    public function getSpecialGroup3(): ?int
    {
        return $this->specialGroup3;
    }

    public function setSpecialGroup3(?int $specialGroup3): self
    {
        $this->specialGroup3 = $specialGroup3;
        return $this;
    }

    public function getSpecialGroup4(): ?int
    {
        return $this->specialGroup4;
    }

    public function setSpecialGroup4(?int $specialGroup4): self
    {
        $this->specialGroup4 = $specialGroup4;
        return $this;
    }

    public function getSpecialGroup5(): ?int
    {
        return $this->specialGroup5;
    }

    public function setSpecialGroup5(?int $specialGroup5): self
    {
        $this->specialGroup5 = $specialGroup5;
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
