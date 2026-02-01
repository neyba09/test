<?php

namespace App\Console;

use App\Console\Commands\NotifyOverdueTasks;
use App\Jobs\NotifyOverdueTasksJob;
use App\Services\TaskService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('tasks:notify-overdue')->hourly();
    }

    /**
     * Регистрация всех команд.
     */
    protected $commands = [
        NotifyOverdueTasks::class,
    ];

}
