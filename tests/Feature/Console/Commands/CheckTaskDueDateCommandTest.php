<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Task;
use App\Models\User;
use App\Notifications\OneDayBeforeDeadlineNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CheckTaskDueDateCommandTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ifATasksDueDateIsApproachingAnEmailNotificationShouldBeSentToAssignee()
    {
        /** @var Task $task */
        $task = Task::factory()
            ->for(User::factory(), 'creator')
            ->for(User::factory(), 'assignee')
            ->due(today())
            ->create();

        Notification::fake();
        $this->artisan('duedate:check');
        Notification::assertSentTo($task->assignee, OneDayBeforeDeadlineNotification::class);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ifATasksDueDateIsApproachingAnEmailNotificationShouldBeSentToCreator()
    {
        /** @var Task $task */
        $task = Task::factory()
            ->for(User::factory(), 'creator')
            ->for(User::factory(), 'assignee')
            ->due(today())
            ->create();

        Notification::fake();
        $this->artisan('duedate:check');
        Notification::assertSentTo($task->creator, OneDayBeforeDeadlineNotification::class);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ifATasksDueDateIsApproachingItsPriorityShouldBeSetToHigh()
    {
        /** @var Task $task */
        $task = Task::factory()
            ->for(User::factory(), 'creator')
            ->for(User::factory(), 'assignee')
            ->due(today())
            ->create();

        Notification::fake();
        $this->artisan('duedate:check');

        $this->assertEquals('HIGH', $task->refresh()->priority);
    }
}
