<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\OneDayBeforeDeadlineNotification;
use Illuminate\Console\Command;

class CheckTaskDueDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'duedate:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        Task::where('due', ">=", today()->subDay())->chunk(100, function ($tasks) {
            $tasks->map(function ($task) {
                $task->update(['priority' => 'HIGH']);
                /** @var Task $task */
                $task->creator->notify(new OneDayBeforeDeadlineNotification($task));
                $task->assignee->notify(new OneDayBeforeDeadlineNotification($task));
            });
        });
    }
}
