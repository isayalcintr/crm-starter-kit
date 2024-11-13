<?php

namespace App\Services;

use App\Models\User;
use App\Objects\User\UserFilterObject;
use App\Objects\User\UserObject;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function list(UserFilterObject $userFilterObject)
    {
        $builder = $this->userRepository->users();
        if (!empty(trim($userFilterObject->getSearch()))){
            return $builder->whereRaw("CONCAT(name, ' ', surname, ' ', email, ' ', role.name) LIKE ?", ['%'.$userFilterObject->getSearch().'%']);
        }
        return $builder;
    }

    public function select(UserFilterObject $userFilterObject)
    {
        $builder = $this->userRepository->usersWithSelect();
        if (!empty(trim($userFilterObject->getSearch()))){
            return $builder->whereRaw("CONCAT(name, ' ', surname, ' ', email) LIKE ?", ['%'.$userFilterObject->getSearch().'%']);
        }
        return $builder;
    }


    public function store(UserObject $userObject): User
    {
        return DB::transaction(function () use ($userObject) {
            $user = $this->userRepository->create($userObject);
            return $user;
        });
    }

    public function destroy(User $user)
    {
        return DB::transaction(function () use ($user) {
            return $this->userRepository->delete($user);
        });
    }

    public function update(UserObject $userObject)
    {
        return DB::transaction(function () use ($userObject) {
            $user = $this->userRepository->update($userObject);
            return $user;
        });
    }
}
