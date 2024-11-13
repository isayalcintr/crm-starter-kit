<?php

namespace App\Objects\Product;

use App\Objects\BaseObject;

class ProductFilterObject extends BaseObject
{
    protected ?string $id = null;
    protected ?string $code = null;
    protected ?string $name = null;
    protected ?string $search = null;
    protected ?int $limit = 100;
    public function __construct(?string $id = null, ?string $code = null, ?string $name = null, ?string $search = null, ?int $limit = 100)
    {
        $this->setId($id);
        $this->setCode($code);
        $this->setName($name);
        $this->setSearch($search);
        $this->setLimit($limit);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): static
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

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): static
    {
        $this->search = $search;
        return $this;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function setLimit(?int $limit): static
    {
        $this->limit = $limit;
        return $this;
    }
}
