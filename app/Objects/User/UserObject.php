<?php

namespace App\Objects\User;

use App\Models\User;
use App\Objects\BaseObject;

class UserObject extends BaseObject
{
    protected ?User $user = null;
    protected ?int $id = null;
    protected ?string $name = null;
    protected ?string $surname = null;
    protected ?string $email = null;
    protected ?string $password = null;
    protected ?int $roleId = null;
    protected ?bool $status = null;

    public function __construct(?User $user = null, ?int $id = null, ?string $name = null, ?string $surname = null, ?string $email = null, ?string $password = null, ?int $roleId = null, ?string $status = null)
    {
        $this->user = $user;
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
        $this->roleId = $roleId;
        $this->status = $status;
    }

    public function getUser(): ?User
    {
        return $this->user ?? new User();
    }

    public function setUser(User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function findUser()
    {
        return User::find($this->id);
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): static
    {
        $this->surname = $surname;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    public function setRoleId(?int $roleId): static
    {
        $this->roleId = $roleId;
        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): static
    {
        $this->status = $status;
        return $this;
    }
}
