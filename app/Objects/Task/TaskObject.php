<?php

namespace App\Objects\Task;

use App\Models\Task;
use App\Objects\BaseObject;

class TaskObject extends BaseObject
{
    protected ?Task $task = null;
    protected ?int $id = null;
    protected ?string $subject = null;
    protected ?string $description = null;
    protected ?string $startDate = null;
    protected ?string $endDate = null;
    protected ?int $priority = null;
    protected ?int $status = null;
    protected ?int $categoryId = null;
    protected ?int $specialGroup1 = null;
    protected ?int $specialGroup2 = null;
    protected ?int $specialGroup3 = null;
    protected ?int $specialGroup4 = null;
    protected ?int $specialGroup5 = null;
    protected ?int $incumbentBy = null;
    protected ?int $createdBy = null;
    protected ?int $updatedBy = null;
    protected ?int $deletedBy = null;

    public function __construct(?Task $task = null, ?int $id = null, ?string $subject = null, ?string $description = null, ?string $startDate = null, ?string $endDate = null, ?int $priority = null, ?int $status = null, ?int $categoryId = null, ?int $specialGroup1 = null, ?int $specialGroup2 = null, ?int $specialGroup3 = null, ?int $specialGroup4 = null, ?int $specialGroup5 = null, ?int $incumbentBy = null, ?int $createdBy = null, ?int $updatedBy = null, ?int $deletedBy = null)
    {
        $this->setTask($task);
        $this->setId($id);
        $this->setSubject($subject);
        $this->setDescription($description);
        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
        $this->setPriority($priority);
        $this->setStatus($status);
        $this->setCategoryId($categoryId);
        $this->setSpecialGroup1($specialGroup1);
        $this->setSpecialGroup2($specialGroup2);
        $this->setSpecialGroup3($specialGroup3);
        $this->setSpecialGroup4($specialGroup4);
        $this->setSpecialGroup5($specialGroup5);
        $this->setIncumbentBy($incumbentBy);
        $this->setCreatedBy($createdBy);
        $this->setUpdatedBy($updatedBy);
        $this->setDeletedBy($deletedBy);
    }


    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): static
    {
        $this->task = $task;
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

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): static
    {
        $this->subject = $subject;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(?string $startDate): static
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate): static
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): static
    {
        $this->priority = $priority;
        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(?int $categoryId): static
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    public function getSpecialGroup1(): ?int
    {
        return $this->specialGroup1;
    }

    public function setSpecialGroup1(?int $specialGroup1): static
    {
        $this->specialGroup1 = $specialGroup1;
        return $this;
    }

    public function setSpecialGroup2(?int $specialGroup2): static
    {
        $this->specialGroup2 = $specialGroup2;
        return $this;
    }

    public function setSpecialGroup3(?int $specialGroup3): static
    {
        $this->specialGroup3 = $specialGroup3;
        return $this;
    }

    public function setSpecialGroup4(?int $specialGroup4): static
    {
        $this->specialGroup4 = $specialGroup4;
        return $this;
    }

    public function setSpecialGroup5(?int $specialGroup5): static
    {
        $this->specialGroup5 = $specialGroup5;
        return $this;
    }

    public function setIncumbentBy(?int $incumbentBy): static
    {
        $this->incumbentBy = $incumbentBy;
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
