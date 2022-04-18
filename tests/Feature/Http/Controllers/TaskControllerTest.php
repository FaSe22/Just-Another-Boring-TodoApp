<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function TasksCanBeStoredByAuthenticatedUser()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)->post('tasks', [
            'title' => 'title',
            'priority' => 'LOW',
            'state' => 'TODO'
        ])->assertSuccessful();

        $this->assertDatabaseCount('tasks', 1);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ItIsForbiddenToCreateTasksIfUAreUnauthorized()
    {
        $this->post('tasks', [
            'title' => 'title',
            'priority' => 'LOW',
            'state' => 'TODO'
        ])->assertForbidden();
    }

}
