<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskRepository
{
    public function paginateByUser(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Task::where('user_id', $userId)
            ->orderBy('due_date')
            ->paginate($perPage);
    }

    public function findByUserId(int $userId, int $taskId): ?Task
    {
        return Task::where('id', $taskId)
            ->where('user_id', $userId)
            ->first();
    }

    public function create($data, User $user)
    {
        return Task::create([
            'user_id' => $user->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
            'due_date' => $data['due_date'] ?? null,
        ]);
    }

    public function update(Task $task, array $data): Task
    {
        $task->fill($data);
        $task->save();

        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}
