<?php
/**
 * Class UserTest
 * @package Tests\Models
 * @author Sebastian Faber <sebastian@startup-werk.de>
 */

namespace Tests\Models;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function aUserCanHaveTasks()
    {
        /** @var User $user */
        $user = User::factory()->has(Task::factory(3))->create();
        $this->assertCount(3, $user->tasks);

    }

}
