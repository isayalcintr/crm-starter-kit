<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Objects\Task\TaskFilterObject;
use App\Objects\Task\TaskObject;
use App\Repositories\Task\TaskRepository;
use Illuminate\Support\Facades\DB;

class TaskService
{
    protected TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function list(TaskFilterObject $filter): \Illuminate\Database\Eloquent\Builder
    {
        $builder = $this->taskRepository->tasks();
        if (!empty(trim($filter->getSearch())))
            $builder->where(DB::raw("
                    CONCAT_WS(' ', task.code, task.subject,
                        IFNULL(category.name, ''),
                        IFNULL(special_group1.name, ''),
                        IFNULL(special_group2.name, ''),
                        IFNULL(special_group3.name, ''),
                        IFNULL(special_group4.name, ''),
                        IFNULL(special_group5.name, '')
                    )
                "), 'LIKE', "%".trim($filter->getSearch())."%");
        if ($filter->getId() > 0)
            $builder->where('tasks.id', $filter->getId());
        return $builder;
    }

    public function store(TaskObject $object)
    {
        return DB::transaction(function () use ($object) {
            return $this->taskRepository->create($object);
        });
    }

    public function update(TaskObject $object)
    {
        return DB::transaction(function () use ($object) {
            $task = $this->taskRepository->update($object);
            return $task;
        });
    }

    public function destroy(TaskObject $object)
    {
        return DB::transaction(function () use ($object) {
            $this->taskRepository->update($object->setTargetProperty("deleted_by"));
            return $this->taskRepository->delete($object->getTask());
        });
    }

}
