<?php

namespace App\Objects\Customer;

use App\Objects\BaseObject;

class CustomerFilterObject extends BaseObject
{
    protected ?int $id = null;
    protected ?string $search = null;

    public function __construct(?int $id = null, ?string $search = null)
    {
        $this->setSearch($search);
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

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): self
    {
        $this->search = $search;
        return $this;
    }
}
