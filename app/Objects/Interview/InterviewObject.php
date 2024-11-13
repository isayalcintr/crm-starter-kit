<?php

namespace App\Objects\Interview;

use App\Models\Interview;
use App\Objects\BaseObject;

class InterviewObject extends BaseObject
{
    protected ?Interview $interview = null;
    protected ?int $id = null;
    protected ?int $customerId = null;
    protected ?string $code = null;
    protected ?string $subject = null;
    protected ?string $description = null;
    protected ?string $categoryId = null;
    protected ?int $typeId = null;
    protected ?int $specialGroup1Id = null;
    protected ?int $specialGroup2Id = null;
    protected ?int $specialGroup3Id = null;
    protected ?int $specialGroup4Id = null;
    protected ?int $specialGroup5Id = null;
    protected ?int $createdBy = null;
    protected ?int $updatedBy = null;
    protected ?int $deletedBy = null;

    public function __construct(?Interview $interview = null, ?int $id = null, ?int $customerId = null, ?string $code = null, ?string $subject = null, ?string $description = null, ?string $categoryId = null, ?int $typeId = null, ?int $specialGroup1Id = null, ?int $specialGroup2Id = null, ?int $specialGroup3Id = null, ?int $specialGroup4Id = null, ?int $specialGroup5Id = null, ?int $createdBy = null, ?int $updatedBy = null, ?int $deletedBy = null){
        $this->setInterview($interview);
        $this->setId($id);
        $this->setCustomerId($customerId);
        $this->setCode($code);
        $this->setSubject($subject);
        $this->setDescription($description);
        $this->setCategoryId($categoryId);
        $this->setTypeId($typeId);
        $this->setSpecialGroup1Id($specialGroup1Id);
        $this->setSpecialGroup2Id($specialGroup2Id);
        $this->setSpecialGroup3Id($specialGroup3Id);
        $this->setSpecialGroup4Id($specialGroup4Id);
        $this->setSpecialGroup5Id($specialGroup5Id);
        $this->setCreatedBy($createdBy);
        $this->setUpdatedBy($updatedBy);
        $this->setDeletedBy($deletedBy);
    }

    public function getInterview(): ?Interview
    {
        return $this->interview;
    }

    public function setInterview(?Interview $interview): self
    {
        $this->interview = $interview;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;
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

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }

    public function setCategoryId(?string $categoryId): self
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    public function getTypeId(): ?int
    {
        return $this->typeId;
    }

    public function setTypeId(?int $typeId): self
    {
        $this->typeId = $typeId;
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
