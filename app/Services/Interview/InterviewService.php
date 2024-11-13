<?php

namespace App\Services\Interview;

use App\Models\Interview;
use App\Objects\Interview\InterviewFilterObject;
use App\Objects\Interview\InterviewObject;
use App\Repositories\Interview\InterviewRepository;
use Illuminate\Support\Facades\DB;

class InterviewService
{
    protected InterviewRepository $interviewRepository;

    public function __construct(InterviewRepository $interviewRepository){
        $this->interviewRepository = $interviewRepository;
    }

    public function list(InterviewFilterObject $filter): \Illuminate\Database\Eloquent\Builder
    {
        $builder = $this->interviewRepository->interviews();
        if (!empty(trim($filter->getSearch())))
            $builder->where(DB::raw("
                    CONCAT_WS(' ', interview.code, interview.subject,
                        IFNULL(category.name, ''),
                        IFNULL(type.name, ''),
                        IFNULL(special_group1.name, ''),
                        IFNULL(special_group2.name, ''),
                        IFNULL(special_group3.name, ''),
                        IFNULL(special_group4.name, ''),
                        IFNULL(special_group5.name, '')
                    )
                "), 'LIKE', "%".trim($filter->getSearch())."%");
        if ($filter->getId() > 0)
            $builder->where('interviews.id', $filter->getId());
        return $builder;
    }

    public function store(InterviewObject $object)
    {
        return DB::transaction(function () use ($object) {
            return $this->interviewRepository->create($object);
        });
    }

    public function update(InterviewObject $object)
    {
        return DB::transaction(function () use ($object) {
            $interview = $this->interviewRepository->update($object);
            return $interview;
        });
    }

    public function destroy(InterviewObject $object): bool
    {
        return DB::transaction(function () use ($object) {
            $this->interviewRepository->update($object->setTargetProperty("deleted_by"));
            return $this->interviewRepository->delete($object->getInterview());
        });
    }
}
