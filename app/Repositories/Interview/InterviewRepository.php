<?php

namespace App\Repositories\Interview;

use App\Models\Interview;
use App\Objects\Interview\InterviewObject;

class InterviewRepository
{
    public function interviews(): \Illuminate\Database\Eloquent\Builder
    {
        return Interview::with([
            'customer',
            'creator',
            'updater',
            'deleter',
            'category',
            'type',
            'specialGroup1',
            'specialGroup2',
            'specialGroup3',
            'specialGroup4',
            'specialGroup5',
        ]);
    }

    public function getInterview(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->interviews()->get();
    }

    public function create(InterviewObject $object)
    {
        return Interview::create($object->toArrayForSnakeCase());
    }

    public function update(InterviewObject $object): ?Interview
    {
        return $this->updateWithArray($object->getInterview(), $object->toArrayForSnakeCase());
    }

    public function updateWithArray(Interview $interview, array $data): ?Interview
    {
        $interview->update($data);
        return $interview;
    }

    public function delete(Interview $interview): ?bool
    {
        return $interview->delete();
    }
}
