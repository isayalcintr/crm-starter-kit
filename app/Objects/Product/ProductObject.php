<?php

namespace App\Objects\Product;

use App\Models\Product\Product;
use App\Objects\BaseObject;

class ProductObject extends BaseObject
{
    protected ?Product $product = null;
    protected ?int $id = null;
    protected ?string $code = null;
    protected ?string $name = null;
    protected ?int $unitId = null;
    protected ?float $purchaseVatRate = 0;
    protected ?float $purchasePrice = 0;
    protected ?float $sellVatRate = 0;
    protected ?float $sellPrice = 0;
    protected ?float $quantity = 0;
    protected ?int $specialGroup1Id = null;
    protected ?int $specialGroup2Id = null;
    protected ?int $specialGroup3Id = null;
    protected ?int $specialGroup4Id = null;
    protected ?int $specialGroup5Id = null;
    protected ?int $type = null;
    protected ?int $createdBy = null;
    protected ?int $updatedBy = null;
    protected ?int $deletedBy = null;

    public function __construct(?Product $product = null, ?int $id = null, ?string $code = null, ?string $name = null, ?int $unitId = null, ?float $purchaseVatRate = 0, ?float $purchasePrice = 0, ?float $sellVatRate = 0, ?float $sellPrice = 0, ?float $quantity = 0, ?int $specialGroup1Id = null, ?int $specialGroup2Id = null, ?int $specialGroup3Id = null, ?int $specialGroup4Id = null, ?int $specialGroup5Id = null, ?int $type = null, ?int $createdBy = null, ?int $updatedBy = null, ?int $deletedBy = null)
    {
        $this->setProduct($product);
        $this->setId($id);
        $this->setCode($code);
        $this->setName($name);
        $this->setUnitId($unitId);
        $this->setPurchaseVatRate($purchaseVatRate);
        $this->setPurchasePrice($purchasePrice);
        $this->setSellVatRate($sellVatRate);
        $this->setSellPrice($sellPrice);
        $this->setQuantity($quantity);
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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getUnitId(): ?int
    {
        return $this->unitId;
    }

    public function setUnitId(?int $unitId): static
    {
        $this->unitId = $unitId;
        return $this;
    }

    public function getPurchaseVatRate(): ?float
    {
        return $this->purchaseVatRate;
    }

    public function setPurchaseVatRate(?float $purchaseVatRate): static
    {
        $this->purchaseVatRate = $purchaseVatRate;
        return $this;
    }

    public function getPurchasePrice(): ?float
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(?float $purchasePrice): static
    {
        $this->purchasePrice = $purchasePrice;
        return $this;
    }

    public function getSellVatRate(): ?float
    {
        return $this->sellVatRate;
    }

    public function setSellVatRate(?float $sellVatRate): static
    {
        $this->sellVatRate = $sellVatRate;
        return $this;
    }

    public function getSellPrice(): ?float
    {
        return $this->sellPrice;
    }

    public function setSellPrice(?float $sellPrice): static
    {
        $this->sellPrice = $sellPrice;
        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): static
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getSpecialGroup1Id(): ?int
    {
        return $this->specialGroup1Id;
    }

    public function setSpecialGroup1Id(?int $specialGroup1Id): static
    {
        $this->specialGroup1Id = $specialGroup1Id;
        return $this;
    }

    public function getSpecialGroup2Id(): ?int
    {
        return $this->specialGroup2Id;
    }

    public function setSpecialGroup2Id(?int $specialGroup2Id): static
    {
        $this->specialGroup2Id = $specialGroup2Id;
        return $this;
    }

    public function getSpecialGroup3Id(): ?int
    {
        return $this->specialGroup3Id;
    }

    public function setSpecialGroup3Id(?int $specialGroup3Id): static
    {
        $this->specialGroup3Id = $specialGroup3Id;
        return $this;
    }

    public function getSpecialGroup4Id(): ?int
    {
        return $this->specialGroup4Id;
    }

    public function setSpecialGroup4Id(?int $specialGroup4Id): static
    {
        $this->specialGroup4Id = $specialGroup4Id;
        return $this;
    }

    public function getSpecialGroup5Id(): ?int
    {
        return $this->specialGroup5Id;
    }

    public function setSpecialGroup5Id(?int $specialGroup5Id): static
    {
        $this->specialGroup5Id = $specialGroup5Id;
        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?int $createdBy): static
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?int $updatedBy): static
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    public function getDeletedBy(): ?int
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(?int $deletedBy): static
    {
        $this->deletedBy = $deletedBy;
        return $this;
    }

}
