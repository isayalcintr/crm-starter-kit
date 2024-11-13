<?php

namespace App\Objects\User;

use App\Objects\BaseObject;

class UserFilterObject extends BaseObject
{
    protected ?string $search = null;

    public function __construct(?string $search = null)
    {
        $this->search = $search;
    }

    /**
     * @return ?string
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * @param $search
     * @return static
     */
    public function setSearch($search): static
    {
        $this->search = $search;
        return $this;
    }
}
