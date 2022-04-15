<?php

namespace App\Listeners;

use App\Models\Task;
use App\Notifications\NewTaskNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAssignee
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        /** @var Task $task
         */
        $task = $event->task;
        if (($task->wasChanged('assignee_id') || $task->wasRecentlyCreated) && $task->refresh()->assignee) {
            $task->assignee->notify(new NewTaskNotification($task));
        }
    }
}
