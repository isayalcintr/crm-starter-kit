<?php

namespace App\Objects\Group;

use App\Models\Group;
use App\Objects\BaseObject;

class GroupObject extends BaseObject
{
    protected ?Group $group = null;
    protected ?int $id = null;
    protected ?string $title = null;
    protected ?int $section = null;
    protected ?int $type = null;
    protected ?int $order = null;
    protected ?bool $isSystem;

    public function __construct(?Group $group = null, ?int $id = null, ?string $title = null, ?int $section = null, ?int $type = null, ?int $order = null, ?bool $isSystem = false)
    {
        $this->setGroup($group);
        $this->setId($id);
        $this->setTitle($title);
        $this->setSection($section);
        $this->setType($type);
        $this->setOrder($order);
        $this->setIsSystem($isSystem);
    }

    /**
     * @return Group
     */
    public function getGroup(): Group
    {
        return $this->group ?? new Group();
    }

    /**
     * @param Group $group
     */
    public function setGroup(?Group $group): static
    {
        $this->group = $group;
        return $this;
    }

    public function findGroup(): static
    {
        $this->setGroup(Group::first($this->id));
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): static
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
    public function getOrder(): ?int
    {
        return $this->order;
    }
    public function setOrder(?int $order): static
    {
        $this->order = $order;
        return $this;
    }
    public function getIsSystem(): ?bool
    {
        return $this->isSystem;
    }
    public function setIsSystem(?bool $isSystem): static
    {
        $this->isSystem = $isSystem;
        return $this;
    }
}
