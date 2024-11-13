<?php

namespace App\Objects\Task;

use App\Objects\BaseObject;

class TaskFilterObject extends BaseObject
{
    protected ?int $id = null;
    protected ?string $search = null;

    public function __construct(?int $id = null, ?string $search = null)
    {
        $this->setId($id);
        $this->setSearch($search);
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

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): static
    {
        $this->search = $search;
        return $this;
    }
}
