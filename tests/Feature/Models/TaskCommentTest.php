<?php

namespace Tests\Feature\Models;

use App\Models\Task;
use App\Models\TaskComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCommentTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ifTheAuthorIsDeletedHisTaskCommentsShouldBeDeletedToo()
    {
        $user = User::factory()
            ->has(TaskComment::factory(10)
                ->for(Task::factory()
                    ->for(User::factory(), 'creator')))
            ->create();

        $user->delete();
        $this->assertDatabaseCount('task_comments', 0);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ifTheTaskIsDeletedHisCommentsShouldBeDeletedToo()
    {
        $task = Task::factory()
            ->for(User::factory(), 'creator')
            ->has(
                TaskComment::factory(10)
                ->for(User::factory(), 'author'),
                'comments'
            )
            ->create();

        $task->delete();
        $this->assertDatabaseCount('task_comments', 0);
    }
}
