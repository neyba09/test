<?php

namespace App\Jobs;

use App\Services\TaskService;
use App\Mail\TaskOverdueMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyOverdueTasksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function handle(): void
    {
        $tasks = $this->taskService->getOverdueTasks();

        foreach ($tasks as $task) {
            Mail::to($task->user->email)->queue(new TaskOverdueMail($task));
        }
    }
}
