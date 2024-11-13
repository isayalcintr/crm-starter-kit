<?php
namespace App\Objects\Role;

use App\Objects\BaseObject;
use Spatie\Permission\Models\Role;

class RoleObject extends BaseObject
{
    protected ?Role $role = null;
    protected ?int $id = null;
    protected ?string $name = null;
    protected ?array $permissions = null;

    public function __construct(?Role $role = null, ?int $id = null, ?string $name = null, ?array $permissions = null)
    {
        $this->role = $role;
        $this->id = $id;
        $this->name = $name;
        $this->permissions = $permissions;
    }

    public function getRole(): ?Role
    {
        return $this->role ?? new Role();
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function findRole(): Role
    {
        return Role::findById($this->id);
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

    public function getPermissions(): ?array
    {
        return $this->permissions;
    }

    public function setPermissions(?array $permissions): static
    {
        $this->permissions = $permissions;
        return $this;
    }
}
