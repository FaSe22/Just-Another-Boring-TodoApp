<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\TaskHistory;
use App\Notifications\NewTaskNotification;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function created(Task $task)
    {
        if ($task->assignee && $task->assignee->shouldBeNotifiedOnAssignment($task)) {
            $task->assignee->notify(new NewTaskNotification($task));
        }
    }

    /**
     * Handle the Task "updated" event.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function updated(Task $task)
    {
        if ($task->wasChanged('assignee_id') && $task->refresh()->assignee && $task->assignee->shouldBeNotifiedOnAssignment($task)) {
            $task->assignee->notify(new NewTaskNotification($task));
        }

        if ($task->wasChanged('state')) {
            TaskHistory::create([
                'task_id' => $task->id,
                'state' => $task->state,
            ]);
        }
    }

    /**
     * Handle the Task "deleted" event.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function deleted(Task $task)
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
