<?php
/**
 * Class HasNotificationSettings
 * @package App\Traits
 * @author Sebastian Faber <sebastian@startup-werk.de>
 */

namespace App\Traits;

use App\Models\Task;

trait HasNotificationSettings
{
    //check if there is an entry in notification_settings table for that user where on_assignment is true
    public function shouldBeNotifiedOnAssignment(Task $task)
    {
        return ($this->notificationSettings()
                ->where('on_assignment', true)
                ->exists()
            && ! $this->notificationSettings()
                ->where('task_id', $task->id)
                ->where('on_assignment', false)
                ->exists());
    }
}
