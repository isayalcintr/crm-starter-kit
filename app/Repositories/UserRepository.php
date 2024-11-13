<?php

namespace App\Repositories;

use App\Models\User;
use App\Objects\User\UserObject;
use Illuminate\Support\Facades\DB;

class UserRepository
{

    public function users(): \Illuminate\Database\Eloquent\Builder
    {
        return User::with('role:id,name');
    }

    public function getUsers(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->users()->get();
    }

    public function usersWithSelect()
    {
        return User::select(DB::raw("CONCAT(name, ' ',  surname) as text"), 'id as id');
    }

    public function create(UserObject $userObject)
    {
        return User::create($userObject->toArrayForSnakeCase());
    }

    public function delete(User $user): ?bool
    {
        return $user->delete();
    }

    public function update(UserObject $userObject): User
    {
        $user = $userObject->getUser();
        $user->update($userObject->toArrayForSnakeCase());
        return $user;
    }
}
