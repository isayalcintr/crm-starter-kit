<?php

namespace App\Objects\Interview;

use App\Objects\BaseObject;

class InterviewFilterObject extends BaseObject
{
    protected ?string $id = null;
    protected ?string $search = null;

    public function __construct(?string $id = null, ?string $search = null)
    {
        $this->setId($id);
        $this->setSearch($search);
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
