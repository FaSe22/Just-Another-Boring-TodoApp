<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Task;
use App\Models\User;
use App\Notifications\OneDayBeforeDeadlineNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * @property $task
 */
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

        Notification::fake();
        $this->artisan('duedate:check');
        Notification::assertSentTo($this->task->assignee, OneDayBeforeDeadlineNotification::class);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ifATasksDueDateIsApproachingAnEmailNotificationShouldBeSentToCreator()
    {

        Notification::fake();
        $this->artisan('duedate:check');
        Notification::assertSentTo($this->task->creator, OneDayBeforeDeadlineNotification::class);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ifATasksDueDateIsApproachingItsPriorityShouldBeSetToHigh()
    {

        Notification::fake();
        $this->artisan('duedate:check');

        $this->assertEquals('HIGH', $this->task->refresh()->priority);
    }

    protected function setUp(): void
    {
        parent::setUp();
        /** @var Task $task */
        $this->task = Task::factory()
            ->for(User::factory(), 'creator')
            ->for(User::factory(), 'assignee')
            ->due(today())
            ->create();
    }

}
