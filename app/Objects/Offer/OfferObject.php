<?php

namespace App\Objects\Offer;

use App\Models\Offer\Offer;
use App\Objects\BaseObject;

class OfferObject extends BaseObject
{
    protected ?Offer $offer = null;
    protected ?int $id = null;
    protected ?int $customerId = null;
    protected ?string $description = null;
    protected ?int $specialGroup1Id = null;
    protected ?int $specialGroup2Id = null;
    protected ?int $specialGroup3Id = null;
    protected ?int $specialGroup4Id = null;
    protected ?int $specialGroup5Id = null;
    protected ?string $date = null;
    protected ?string $validityDate = null;
    protected ?float $stockTotal = null;
    protected ?float $serviceTotal = null;
    protected ?float $discountTotal = null;
    protected ?float $subTotal = null;
    protected ?float $vatTotal = null;
    protected ?float $total = null;
    protected ?int $status = null;
    protected ?int $stage = null;
    /**
     * @var OfferItemObject[]|null
     */
    protected ?array $items = [];
    protected ?int $approvedBy = null;
    protected ?string $approvedDate = null;
    protected ?int $cancelledBy = null;
    protected ?string $cancelledDate = null;
    protected ?int $createdBy = null;
    protected ?int $updatedBy = null;
    protected ?int $deletedBy = null;

    public function __construct(?Offer $offer = null, ?int $id = null, ?int $customerId = null, ?string $description = null, ?int $specialGroup1Id = null, ?int $specialGroup2Id = null, ?int $specialGroup3Id = null, ?int $specialGroup4Id = null, ?int $specialGroup5Id = null, ?string $date = null, ?string $validityDate = null, ?float $stockTotal = null, ?float $serviceTotal = null, ?float $discountTotal = null, ?float $subTotal = null, ?float $vatTotal = null, ?float $total = null, ?int $status = null, ?int $stage = null, ?array $items = null, ?int $approvedBy = null, ?int $approvedDate = null, ?int $cancelledBy = null, ?int $cancelledDate = null, ?int $createdBy = null, ?int $updatedBy = null, ?int $deletedBy = null) {
        $this->setOffer($offer)
            ->setId($id)
            ->setCustomerId($customerId)
            ->setDescription($description)
            ->setSpecialGroup1Id($specialGroup1Id)
            ->setSpecialGroup2Id($specialGroup2Id)
            ->setSpecialGroup3Id($specialGroup3Id)
            ->setSpecialGroup4Id($specialGroup4Id)
            ->setSpecialGroup5Id($specialGroup5Id)
            ->setDate($date)
            ->setValidityDate($validityDate)
            ->setStockTotal($stockTotal)
            ->setServiceTotal($serviceTotal)
            ->setDiscountTotal($discountTotal)
            ->setSubTotal($subTotal)
            ->setVatTotal($vatTotal)
            ->setTotal($total)
            ->setStatus($status)
            ->setStage($stage)
            ->setItems($items)
            ->setApprovedBy($approvedBy)
            ->setApprovedDate($approvedDate)
            ->setCancelledBy($cancelledBy)
            ->setCancelledDate($cancelledDate)
            ->setCreatedBy($createdBy)
            ->setUpdatedBy($updatedBy)
            ->setDeletedBy($deletedBy);
    }

    public function setOffer(?Offer $offer): self {
        $this->offer = $offer;
        return $this;
    }

    public function getOffer(): ?Offer {
        return $this->offer;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setCustomerId(?int $customerId): self {
        $this->customerId = $customerId;
        return $this;
    }

    public function getCustomerId(): ?int {
        return $this->customerId;
    }

    public function setDescription(?string $description): self {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setSpecialGroup1Id(?int $specialGroup1Id): self {
        $this->specialGroup1Id = $specialGroup1Id;
        return $this;
    }

    public function getSpecialGroup1Id(): ?int {
        return $this->specialGroup1Id;
    }

    public function setSpecialGroup2Id(?int $specialGroup2Id): self {
        $this->specialGroup2Id = $specialGroup2Id;
        return $this;
    }

    public function getSpecialGroup2Id(): ?int {
        return $this->specialGroup2Id;
    }

    public function setSpecialGroup3Id(?int $specialGroup3Id): self {
        $this->specialGroup3Id = $specialGroup3Id;
        return $this;
    }

    public function getSpecialGroup3Id(): ?int {
        return $this->specialGroup3Id;
    }

    public function setSpecialGroup4Id(?int $specialGroup4Id): self {
        $this->specialGroup4Id = $specialGroup4Id;
        return $this;
    }

    public function getSpecialGroup4Id(): ?int {
        return $this->specialGroup4Id;
    }

    public function setSpecialGroup5Id(?int $specialGroup5Id): self {
        $this->specialGroup5Id = $specialGroup5Id;
        return $this;
    }

    public function getSpecialGroup5Id(): ?int {
        return $this->specialGroup5Id;
    }

    public function setDate(?string $date): self {
        $this->date = $date;
        return $this;
    }

    public function getDate(): ?string {
        return $this->date;
    }

    public function setValidityDate(?string $validityDate): self {
        $this->validityDate = $validityDate;
        return $this;
    }

    public function getValidityDate(): ?string {
        return $this->validityDate;
    }

    public function setStockTotal(?float $stockTotal): self {
        $this->stockTotal = $stockTotal;
        return $this;
    }

    public function getStockTotal(): ?float {
        return $this->stockTotal;
    }

    public function setServiceTotal(?float $serviceTotal): self {
        $this->serviceTotal = $serviceTotal;
        return $this;
    }

    public function getServiceTotal(): ?float {
        return $this->serviceTotal;
    }

    public function setDiscountTotal(?float $discountTotal): self {
        $this->discountTotal = $discountTotal;
        return $this;
    }

    public function getDiscountTotal(): ?float {
        return $this->discountTotal;
    }

    public function setSubTotal(?float $subTotal): self {
        $this->subTotal = $subTotal;
        return $this;
    }

    public function getSubTotal(): ?float {
        return $this->subTotal;
    }

    public function setVatTotal(?float $vatTotal): self {
        $this->vatTotal = $vatTotal;
        return $this;
    }

    public function getVatTotal(): ?float {
        return $this->vatTotal;
    }

    public function setTotal(?float $total): self {
        $this->total = $total;
        return $this;
    }

    public function getTotal(): ?float {
        return $this->total;
    }

    public function setStatus(?int $status): self {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): ?int {
        return $this->status;
    }

    public function setStage(?int $stage): self {
        $this->stage = $stage;
        return $this;
    }

    public function getStage(): ?int {
        return $this->stage;
    }

    public function getItems(): ?array
    {
        return $this->items;
    }

    public function setItems(?array $items): self
    {
        $this->items = array_map(function (array $item) {
            return (new OfferItemObject())->initFromArray($item);
        }, $items ?? []);
        return $this;
    }

    public function setApprovedBy(?int $approvedBy): self {
        $this->approvedBy = $approvedBy;
        return $this;
    }

    public function getApprovedBy(): ?int {
        return $this->approvedBy;
    }

    public function setApprovedDate(?string $approvedDate): self {
        $this->approvedDate = $approvedDate;
        return $this;
    }

    public function getApprovedDate(): ?string {
        return $this->approvedDate;
    }

    public function setCancelledBy(?int $cancelledBy): self {
        $this->cancelledBy = $cancelledBy;
        return $this;
    }

    public function getCancelledBy(): ?int {
        return $this->cancelledBy;
    }

    public function setCancelledDate(?string $cancelledDate): self {
        $this->cancelledDate = $cancelledDate;
        return $this;
    }

    public function getCancelledDate(): ?string {
        return $this->cancelledDate;
    }

    public function setCreatedBy(?int $createdBy): self {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getCreatedBy(): ?int {
        return $this->createdBy;
    }

    public function setUpdatedBy(?int $updatedBy): self {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    public function getUpdatedBy(): ?int {
        return $this->updatedBy;
    }

    public function setDeletedBy(?int $deletedBy): self {
        $this->deletedBy = $deletedBy;
        return $this;
    }

    public function getDeletedBy(): ?int {
        return $this->deletedBy;
    }
}
