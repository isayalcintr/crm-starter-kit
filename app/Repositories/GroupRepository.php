<?php

namespace App\Repositories;

use App\Enums\Group\SectionEnum;
use App\Enums\Group\TypeEnum;
use App\Models\Group;
use App\Objects\Group\GroupObject;
use Illuminate\Support\Facades\DB;

class GroupRepository
{
    public function groups(){
        $builder = Group::select("*");

        $sectionConditions = collect(SectionEnum::cases())
            ->map(function ($item) {
                return "WHEN section = {$item->value} THEN '" . SectionEnum::getLabel($item->value) . "'";
            })
            ->implode(' ');
        $builder->addSelect(DB::raw("(CASE  ".$sectionConditions." ELSE 'Bilinmiyor' END ) AS section_title"));

        $typeConditions = collect(TypeEnum::cases())
            ->map(function ($item){
                return "WHEN type = {$item->value} THEN '" . TypeEnum::getLabel($item->value) . "'";
            })
            ->implode(' ');
        $builder->addSelect(DB::raw("(CASE  ".$typeConditions." ELSE 'Bilinmiyor' END ) AS type_title"));
        return $builder;
    }

    public function getGroups()
    {
        return $this->groups()->get();
    }

    public function groupsWithSelect()
    {
        return Group::select('title as text', 'id as id');
    }

    public function getGroupsWithSelect()
    {
        return $this->groupsWithSelect()->get();
    }

    public function create(GroupObject $object): Group
    {
        return Group::create($object->toArrayForSnakeCase());
    }

    public function update(GroupObject $object): Group
    {
        $group = $object->getGroup();
        $group->update($object->toArrayForSnakeCase());
        return $group;
    }

    public function delete(Group $group): ?bool
    {
        return $group->delete();
    }
}
