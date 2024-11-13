<?php

namespace App\Objects\Group;

use App\Models\Group;
use App\Objects\BaseObject;

class GroupFilterObject extends BaseObject
{
    protected ?string $id = null;
    protected ?string $title = null;
    protected ?int $section = null;
    protected ?int $type = null;

    public function __construct(?int $id = null,?string $title = null, ?int $section = null, ?int $type = null)
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setSection($section);
        $this->setType($type);
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     */
    public function setId(?string $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getSection(): ?int
    {
        return $this->section;
    }

    public function setSection(?int $section): static
    {
        $this->section = $section;
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
}
