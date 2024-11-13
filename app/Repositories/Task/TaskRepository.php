<?php

namespace App\Repositories\Task;

use App\Models\Task;
use App\Objects\Task\TaskObject;

class TaskRepository
{
    public function tasks(): \Illuminate\Database\Eloquent\Builder
    {
        return Task::with([
            'customer',
            'incumbent',
            'creator',
            'updater',
            'deleter',
            'category',
            'specialGroup1',
            'specialGroup2',
            'specialGroup3',
            'specialGroup4',
            'specialGroup5',
        ]);
    }

    public function create(TaskObject $object): ?Task
    {
        return Task::create($object->toArrayForSnakeCase());
    }

    public function update(TaskObject $object): ?Task
    {
        return $this->updateWithArray($object->getTask(), $object->toArrayForSnakeCase());
    }

    public function updateWithArray(Task $task, array $data): ?Task
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task): ?bool
    {
        return $task->delete();
    }
}
