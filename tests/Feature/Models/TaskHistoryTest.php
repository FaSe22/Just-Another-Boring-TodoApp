<?php

namespace Tests\Feature\Models;

use App\Models\Task;
use App\Models\TaskHistory;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskHistoryTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function aTaskHistoryBelongsToATask()
    {
        /** @var Task $task */
        $task = Task::factory()
            ->for(User::factory(), 'creator')
            ->has(TaskHistory::factory()->status('DONE'), 'histories')
            ->create();

        $this->assertNotNull($task->histories);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function creatingATaskHistoryWithoutATaskIdShouldThrowQueryException()
    {
        $this->expectException(QueryException::class);
        TaskHistory::factory()->status('DONE')->create();
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function creatingATaskHistoryWithoutAStateShouldThrowQueryException()
    {
        $this->expectException(QueryException::class);
        TaskHistory::factory()->for(Task::factory())->create();
    }
}
