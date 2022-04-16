<?php
/**
 * Class HasNotificationSettings
 * @package App\Traits
 * @author Sebastian Faber <sebastian@startup-werk.de>
 */

namespace App\Traits;

use App\Models\NotificationSetting;

trait HasNotificationSettings
{
    //check if there is an entry in notification_settings table for that user where on_assignment is true
    public function shouldBeNotifiedOnAssignment()
    {
        return $this->notificationSettings()->where('on_assignment', true)->exists();
    }


}
