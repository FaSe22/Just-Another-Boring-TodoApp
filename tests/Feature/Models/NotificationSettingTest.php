<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationSettingTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ifAUserIsCreatedThereShouldBeDefaultNotificationSettingsForThisUser()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->assertDatabaseCount('notification_settings', 1);
        $this->assertDatabaseHas('notification_settings', [
            'on_creation' => false,
            'on_assignment' => true,
            'one_day_before_deadline' => true,
            'comment_on_your_task' => true,
            'on_state_change' => false
        ]);
        $this->assertNotEmpty($user->notificationSettings()->get());
    }


    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ifUserIsDeletedHisSettingsShouldBeDeletedToo()
    {
        /** @var User $user */
        $user = User::factory()->create();
        //User Observer creates default NotificationSettings for user
        $this->assertDatabaseCount('notification_settings', 1);
        $this->assertDatabaseCount('notification_setting_user', 1);

        $user->delete();

        $this->assertDatabaseCount('notification_settings', 0);
        $this->assertDatabaseCount('notification_setting_user', 0);
    }

}
