<?php

namespace Tests\Feature\Notifications;

use App\Models\Task;
use App\Models\User;
use App\Notifications\NewTaskNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NewTaskNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ifATaskIsCreatedTheAssigneeShouldReceiveANotification()
    {
        Notification::fake();

        /** @var Task $task */
        $task = Task::factory()
            ->for(User::factory(), 'creator')
            ->for(User::factory(), 'assignee')
            ->create();

        Notification::assertSentTo($task->assignee, NewTaskNotification::class);
   }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ifTheAssigneeOfATaskChangesTheNewAssigneeShouldBeNotified()
    {
        Notification::fake();

        /** @var Task $task */
        $task = Task::factory()
            ->for(User::factory(), 'creator')
            ->create();

        /** @var User $assignee */
        $assignee = User::factory()->create();
        $task->update(['assignee_id' => $assignee->id]);

        $this->assertEquals($assignee->id, $task->refresh()->assignee->id);
        Notification::assertSentTo($task->assignee, NewTaskNotification::class);
    }

}
