<?php

namespace App\Listeners;

use App\Events\UpdateTaskEvent;
use App\Models\TaskHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WriteTaskHistory
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
     * @param  \App\Events\UpdateTaskEvent  $event
     * @return void
     */
    public function handle(UpdateTaskEvent $event)
    {
        $task = $event->task;

        if ($task->isDirty('state')) {
            TaskHistory::create([
                'task_id'=>$task->id,
                'state' => $task->state,
            ]);
        }
    }
}
