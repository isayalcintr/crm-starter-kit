<?php

namespace App\Services;

use App\Models\Group;
use App\Objects\Group\GroupFilterObject;
use App\Objects\Group\GroupObject;
use App\Repositories\GroupRepository;
use Illuminate\Support\Facades\DB;

class GroupService
{
    protected GroupRepository $groupRepository;
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }


    public function select(GroupFilterObject $filter)
    {
        $builder = $this->groupRepository->groupsWithSelect();
        if (!empty($filter->getTitle()))
            $builder->where('title', 'like', '%' . $filter->getTitle() . '%');
        if ($filter->getSection() > 0)
            $builder->where('section', $filter->getSection());
        if ($filter->getType() > 0)
            $builder->where('type', $filter->getType());
        return $builder;
    }

    public function list(GroupFilterObject $filter)
    {
        $builder = $this->groupRepository->groups();
        if (!empty($filter->getTitle()))
            $builder->where('title', 'like', '%' . $filter->getTitle() . '%');
        if ($filter->getSection() > 0)
            $builder->where('section', $filter->getSection());
        if ($filter->getType() > 0)
            $builder->where('type', $filter->getType());
        if ($filter->getId() > 0)
            $builder->where('id', $filter->getId());
        return $builder;
    }

    public function store(GroupObject $object)
    {
        return DB::transaction(function () use ($object) {
            return $this->groupRepository->create($object);
        });
    }

    public function update(GroupObject $object)
    {
        return DB::transaction(function () use ($object) {
            $group = $this->groupRepository->update($object);
            return $group;
        });
    }

    public function destroy(Group $group)
    {
        return DB::transaction(function () use ($group) {
            return $this->groupRepository->delete($group);
        });
    }

}
