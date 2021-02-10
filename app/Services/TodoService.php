<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\DTO\TodoData;
use App\Models\Todo;

final class TodoService
{

    public function get(): object
    {
        return Todo::paginate(config('todo_settings.pagination', 10));
    }

    /**
     * @param TodoData $data
     * @return Todo
     * @throws \Throwable
     */
    public function create(TodoData $data): Todo
    {
        return $this->createOrUpdate(new Todo(), $data);
    }

    /**
     * @param Todo $todo
     * @param TodoData $data
     * @return Todo
     * @throws \Throwable
     */
    public function update(Todo $todo, TodoData $data): Todo
    {
        return $this->createOrUpdate($todo, $data);
    }

    /**
     * @param Todo $todo
     * @param TodoData $data
     * @return Todo
     * @throws \Throwable
     */
    protected function createOrUpdate(Todo $todo, TodoData $data): Todo
    {
        $todo->title       = $data->title;
        $todo->description = $data->description;
        $todo->status      = $data->status;

        $todo->save();

        return $todo;
    }

}
