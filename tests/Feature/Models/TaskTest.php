<?php
/**
 * Class TaskTest
 * @package Tests\Models
 * @author Sebastian Faber <sebastian@startup-werk.de>
 */

namespace Tests\Feature\Models;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function aTaskShouldBelongToACreator()
    {
        /** @var Task $task */
        $task = Task::factory()->for(User::factory(), 'creator')->create();
        $this->assertNotNull($task->creator);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function aTaskCanBeAssignedToAnAssignee()
    {
        /** @var User $creator */
        $creator = User::factory()->has(Task::factory()->for(User::factory(), 'assignee'))->create();
        $this->assertNotNull($creator->tasks->map->assignee);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function taskWithoutCreatorIdShouldThrowAQueryException()
    {
        $this->expectException(QueryException::class);
        Task::factory()->create();
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ifAUserIsDeletedAllOfHisTasksShouldBeDeletedToo()
    {
        $user = User::factory()->has(Task::factory(10))->create();
        $user->delete();
        $this->assertDatabaseCount('tasks', 0);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function aTaskWithoutTitleShouldThrowAQueryException()
    {
        $this->expectException(QueryException::class);
        Task::factory()->for(User::factory(), 'creator')->create(['title' => null]);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function aTasksDefaultPriorityShouldBeLow()
    {
        /** @var Task $task */
        $task = Task::factory()->for(User::factory(), 'creator')->create();
        $this->assertEquals('LOW', $task->refresh()->priority);
    }


    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function creatingATaskWithInvalidPriorityValueShouldThrowAQueryException()
    {
        $this->expectException(QueryException::class);
        Task::factory()->for(User::factory(), 'creator')->create(['priority' => '__INVALID_PRIORITY__']);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function updatingATaskWithInvalidPriorityValueShouldThrowAQueryException()
    {
        $task =Task::factory()->for(User::factory(), 'creator')->create();
        $this->expectException(QueryException::class);
        $task->update(['priority' => '__INVALID_PRIORITY__']);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function aTasksDefaultStateShouldBeTODO()
    {
        /** @var Task $task */
        $task = Task::factory()->for(User::factory(), 'creator')->create();
        $this->assertEquals('TODO', $task->refresh()->state);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function creatingATaskWithInvalidStateValueShouldThrowAQueryException()
    {
        $this->expectException(QueryException::class);
        Task::factory()->for(User::factory(), 'creator')->create(['state' => '__INVALID_STATE__']);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function updatingATaskWithInvalidStateValueShouldThrowAQueryException()
    {
        $task =Task::factory()->for(User::factory(), 'creator')->create();
        $this->expectException(QueryException::class);
        $task->update(['state' => '__INVALID_STATE__']);
    }

}
