<?php

namespace App\Repositories;

use App\Enums\UserLogModuleEnum;
use App\Enums\UserLogTypeEnum;
use App\Objects\Role\RoleObject;
use App\Objects\UserLogObject;
use App\Services\UserLogService;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleRepository
{

    public function roles(){
        return Role::select('*', DB::raw('(SELECT count(users.id) FROM users as users WHERE users.role_id = roles.id) as user_count'));
    }

    public function getRoles()
    {
        return $this->roles()->get();
    }

    public function rolesWithSelect(){
        return Role::select('name as text', 'id');
    }

    public function getRolesWithSelect()
    {
        return $this->rolesWithSelect()->get();
    }

    public function create(RoleObject $roleObject): ?Role
    {
        return Role::create($roleObject->toArrayForSnakeCase());
    }

    public function delete(Role $role): ?bool
    {
        return $role->delete();
    }

    public function update(RoleObject $roleObject): ?Role
    {
        $role = $roleObject->getRole();
        $role->update($roleObject->toArrayForSnakeCase());
        return $role;
    }

}
