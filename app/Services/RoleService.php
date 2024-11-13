<?php

namespace App\Services;

use App\Objects\Role\RoleFilterObject;
use App\Objects\Role\RoleObject;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    protected RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function list(RoleFilterObject $roleFilterObject){
        $builder = $this->roleRepository->roles();
        if (!empty(trim($roleFilterObject->getSearch()))){
            return $builder->where('name', 'like', '%'.$roleFilterObject->getSearch().'%');
        }
        return $builder;
    }

    public function listWithSelect(RoleFilterObject $roleFilterObject)
    {
        $builder = $this->roleRepository->rolesWithSelect();
        if (!empty(trim($roleFilterObject->getSearch()))){
            return $builder->where('name', 'like', '%'.$roleFilterObject->getSearch().'%');
        }
        return $builder;
    }

    public function store(RoleObject $roleObject): Role
    {
        return DB::transaction(function () use ($roleObject) {
            foreach ($roleObject->getPermissions() ?? [] as $name){
                Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
            }
            $role = $this->roleRepository->create($roleObject);
            $role->syncPermissions($roleObject->getPermissions());
            return $role;
        });
    }

    public function destroy(Role $role): ?bool
    {
        return DB::transaction(function () use ($role) {
            return $this->roleRepository->delete($role);
        });
    }

    public function update(RoleObject $roleObject)
    {
        return DB::transaction(function () use ($roleObject) {
            foreach ($roleObject->getPermissions() ?? [] as $name){
                Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
            }
            $role = $this->roleRepository->update($roleObject);
            $role->syncPermissions($roleObject->getPermissions());
            return $role;
        });
    }

}
