<?php

namespace App\Objects\Service;

use App\Models\Service\ServiceItem;
use App\Objects\BaseObject;

class ServiceItemObject extends BaseObject
{
    protected ?ServiceItem $serviceItem = null;
    protected ?int $id = null;
    protected ?int $serviceId = null;
    protected ?int $productId = null;
    protected ?string $productName = null;
    protected ?int $productType = null;
    protected ?int $order = null;
    protected ?int $unitId = null;
    protected ?float $quantity = null;
    protected ?float $price = null;
    protected ?float $vatRate = null;
    protected ?float $subTotal = null;
    protected ?float $vatTotal = null;
    protected ?float $total = null;
    protected ?int $specialGroup1 = null;
    protected ?int $specialGroup2 = null;
    protected ?int $specialGroup3 = null;
    protected ?int $specialGroup4 = null;
    protected ?int $specialGroup5 = null;

    public function __construct(?ServiceItem $serviceItem = null, ?int $id = null, ?int $serviceId = null, ?int $productId = null, ?string $productName = null, ?int $productType = null, ?int $order = null, ?int $unitId = null, ?float $quantity = null, ?float $price = null, ?float $vatRate = null, ?float $subTotal = null, ?float $vatTotal = null, ?float $total = null, ?int $specialGroup1 = null, ?int $specialGroup2 = null, ?int $specialGroup3 = null, ?int $specialGroup4 = null, ?int $specialGroup5 = null) {
        $this->setServiceItem($serviceItem)
            ->setId($id)
            ->setServiceId($serviceId)
            ->setProductId($productId)
            ->setProductName($productName)
            ->setProductType($productType)
            ->setOrder($order)
            ->setUnitId($unitId)
            ->setQuantity($quantity)
            ->setPrice($price)
            ->setVatRate($vatRate)
            ->setSubTotal($subTotal)
            ->setVatTotal($vatTotal)
            ->setTotal($total)
            ->setSpecialGroup1($specialGroup1)
            ->setSpecialGroup2($specialGroup2)
            ->setSpecialGroup3($specialGroup3)
            ->setSpecialGroup4($specialGroup4)
            ->setSpecialGroup5($specialGroup5);
    }

    public function getServiceItem(): ?ServiceItem
    {
        return $this->serviceItem;
    }

    public function setServiceItem(?ServiceItem $serviceItem): self
    {
        $this->serviceItem = $serviceItem;
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

    public function getServiceId(): ?int
    {
        return $this->serviceId;
    }

    public function setServiceId(?int $serviceId): self
    {
        $this->serviceId = $serviceId;
        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function setProductId(?int $productId): self
    {
        $this->productId = $productId;
        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(?string $productName): self
    {
        $this->productName = $productName;
        return $this;
    }

    public function getProductType(): ?int
    {
        return $this->productType;
    }

    public function setProductType(?int $productType): self
    {
        $this->productType = $productType;
        return $this;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(?int $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function getUnitId(): ?int
    {
        return $this->unitId;
    }

    public function setUnitId(?int $unitId): self
    {
        $this->unitId = $unitId;
        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getVatRate(): ?float
    {
        return $this->vatRate;
    }

    public function setVatRate(?float $vatRate): self
    {
        $this->vatRate = $vatRate;
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
}
