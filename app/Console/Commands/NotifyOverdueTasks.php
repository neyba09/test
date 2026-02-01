<?php

namespace App\Console\Commands;

use App\Services\TaskService;
use Illuminate\Console\Command;

class NotifyOverdueTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:notify-overdue';
    protected $description = 'Notify users about overdue tasks';

    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        parent::__construct();
        $this->taskService = $taskService;
    }

    public function handle()
    {
        $this->taskService->notifyOverdueTasks();

        $this->info('Overdue tasks notifications sent.');
    }
}
