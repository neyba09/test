<?php

namespace App\Services;

use App\Mail\TaskCreatedMail;
use App\Mail\TaskOverdueMail;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class TaskService
{
    public function __construct(protected TaskRepository $taskRepository)
    {
    }

    public function getTasks(int $userId, int $perPage = 10)
    {
        return $this->taskRepository->paginateByUser($userId, $perPage);
    }

    public function getTaskById(int $userId, int $taskId)
    {
        $task = $this->taskRepository->findByUserId($userId, $taskId);

        if (!$task) {
            abort(404, 'Task not found');
        }

        return $task;
    }

    public function createTask(array $data, User $user): Task
    {
        Log::info('Создание новой задачи', [
            'user_id' => $user->id,
            'data' => $data
        ]);

        $task = $this->taskRepository->create($data, $user);

        Log::info('Отправка email уведомления о новой задаче', [
            'task_id' => $task->id,
            'email' => $user->email
        ]);

        Mail::to($user->email)->queue(new TaskCreatedMail($task));

        Log::info('Задача успешно создана', [
            'task_id' => $task->id
        ]);

        return $task;
    }

    public function updateTask(int $userId, int $taskId, array $data): Task
    {
        $task = $this->taskRepository->findByUserId($userId, $taskId);

        if (!$task) {
            abort(404, 'Task not found');
        }

        return $this->taskRepository->update($task, $data);
    }

    public function deleteTask(int $userId, int $taskId): void
    {
        $task = $this->taskRepository->findByUserId($userId, $taskId);

        if (!$task) {
            abort(Response::HTTP_NOT_FOUND, 'Task not found');
        }

        $this->taskRepository->delete($task);
    }

    public function notifyOverdueTasks(): void
    {
        $tasks = $this->taskRepository->getOverdueTasks();

        foreach ($tasks as $task) {
            if ($task->user && $task->user->email) {
                Mail::to($task->user->email)->send(new TaskOverdueMail($task));
            }
        }
    }
}
