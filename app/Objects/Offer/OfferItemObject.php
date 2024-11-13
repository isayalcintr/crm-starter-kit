<?php

namespace App\Objects\Offer;

use App\Models\Offer\OfferItem;
use App\Objects\BaseObject;

class OfferItemObject extends BaseObject
{
    protected ?OfferItem $offerItem = null;
    protected ?int $id = null;
    protected ?int $offerId = null;
    protected ?int $productId = null;
    protected ?string $productName = null;
    protected ?int $productType = null;
    protected ?int $unitId = null;
    protected ?int $order = null;
    protected ?float $quantity = null;
    protected ?float $price = null;
    protected ?float $discount1 = null;
    protected ?float $discount2 = null;
    protected ?float $discount3 = null;
    protected ?float $discount4 = null;
    protected ?float $discount5 = null;
    protected ?float $discount1Price = null;
    protected ?float $discount2Price = null;
    protected ?float $discount3Price = null;
    protected ?float $discount4Price = null;
    protected ?float $discount5Price = null;
    protected ?float $vatRate = null;
    protected ?float $discountTotal = null;
    protected ?float $subTotal = null;
    protected ?float $vatTotal = null;
    protected ?float $total = null;

    public function __construct(?OfferItem $offerItem = null, ?int $id = null, ?int $offerId = null, ?int $productId = null, ?string $productName = null, ?int $productType = null, ?int $unitId = null, ?int $order = null, ?float $quantity = null, ?float $price = null, ?float $discount1 = null, ?float $discount2 = null, ?float $discount3 = null, ?float $discount4 = null, ?float $discount5 = null, ?float $discount1Price = null, ?float $discount2Price = null, ?float $discount3Price = null, ?float $discount4Price = null, ?float $discount5Price = null, ?float $vatRate = null, ?float $discountTotal = null, ?float $subTotal = null, ?float $vatTotal = null, ?float $total = null) {
        $this->setOfferItem($offerItem)
            ->setId($id)
            ->setOfferId($offerId)
            ->setProductId($productId)
            ->setProductName($productName)
            ->setProductType($productType)
            ->setUnitId($unitId)
            ->setOrder($order)
            ->setQuantity($quantity)
            ->setPrice($price)
            ->setDiscount1($discount1)
            ->setDiscount2($discount2)
            ->setDiscount3($discount3)
            ->setDiscount4($discount4)
            ->setDiscount5($discount5)
            ->setDiscount1Price($discount1Price)
            ->setDiscount2Price($discount2Price)
            ->setDiscount3Price($discount3Price)
            ->setDiscount4Price($discount4Price)
            ->setDiscount5Price($discount5Price)
            ->setVatRate($vatRate)
            ->setDiscountTotal($discountTotal)
            ->setSubTotal($subTotal)
            ->setVatTotal($vatTotal)
            ->setTotal($total);
    }

    public function setOfferItem(?OfferItem $offerItem): self {
        $this->offerItem = $offerItem;
        return $this;
    }

    public function getOfferItem(): ?OfferItem {
        return $this->offerItem;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setOfferId(?int $offerId): self {
        $this->offerId = $offerId;
        return $this;
    }

    public function getOfferId(): ?int {
        return $this->offerId;
    }

    public function setProductId(?int $productId): self {
        $this->productId = $productId;
        return $this;
    }

    public function getProductId(): ?int {
        return $this->productId;
    }

    public function setProductName(?string $productName): self {
        $this->productName = $productName;
        return $this;
    }

    public function getProductName(): ?string {
        return $this->productName;
    }

    public function setProductType(?int $productType): self {
        $this->productType = $productType;
        return $this;
    }

    public function getProductType(): ?int {
        return $this->productType;
    }

    public function setUnitId(?int $unitId): self {
        $this->unitId = $unitId;
        return $this;
    }

    public function getUnitId(): ?int {
        return $this->unitId;
    }

    public function setOrder(?int $order): self {
        $this->order = $order;
        return $this;
    }

    public function getOrder(): ?int {
        return $this->order;
    }

    public function setQuantity(?float $quantity): self {
        $this->quantity = $quantity;
        return $this;
    }

    public function getQuantity(): ?float {
        return $this->quantity;
    }

    public function setPrice(?float $price): self {
        $this->price = $price;
        return $this;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

    public function setDiscount1(?float $discount1): self {
        $this->discount1 = $discount1;
        return $this;
    }

    public function getDiscount1(): ?float {
        return $this->discount1;
    }

    public function setDiscount2(?float $discount2): self {
        $this->discount2 = $discount2;
        return $this;
    }

    public function getDiscount2(): ?float {
        return $this->discount2;
    }

    public function setDiscount3(?float $discount3): self {
        $this->discount3 = $discount3;
        return $this;
    }

    public function getDiscount3(): ?float {
        return $this->discount3;
    }

    public function setDiscount4(?float $discount4): self {
        $this->discount4 = $discount4;
        return $this;
    }

    public function getDiscount4(): ?float {
        return $this->discount4;
    }

    public function setDiscount5(?float $discount5): self {
        $this->discount5 = $discount5;
        return $this;
    }

    public function getDiscount5(): ?float {
        return $this->discount5;
    }

    public function setDiscount1Price(?float $discount1Price): self {
        $this->discount1Price = $discount1Price;
        return $this;
    }

    public function getDiscount1Price(): ?float {
        return $this->discount1Price;
    }

    public function setDiscount2Price(?float $discount2Price): self {
        $this->discount2Price = $discount2Price;
        return $this;
    }

    public function getDiscount2Price(): ?float {
        return $this->discount2Price;
    }

    public function setDiscount3Price(?float $discount3Price): self {
        $this->discount3Price = $discount3Price;
        return $this;
    }

    public function getDiscount3Price(): ?float {
        return $this->discount3Price;
    }

    public function setDiscount4Price(?float $discount4Price): self {
        $this->discount4Price = $discount4Price;
        return $this;
    }

    public function getDiscount4Price(): ?float {
        return $this->discount4Price;
    }

    public function setDiscount5Price(?float $discount5Price): self {
        $this->discount5Price = $discount5Price;
        return $this;
    }

    public function getDiscount5Price(): ?float {
        return $this->discount5Price;
    }

    public function setVatRate(?float $vatRate): self {
        $this->vatRate = $vatRate;
        return $this;
    }

    public function getVatRate(): ?float {
        return $this->vatRate;
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
}
