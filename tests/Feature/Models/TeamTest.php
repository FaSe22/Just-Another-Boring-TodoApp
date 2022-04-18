<?php

namespace Tests\Feature\Models;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function aTeamCanConsistOfManyUsers()
    {
        /** @var Team $team */
        $team = Team::factory()->has(User::factory(3), 'members')->create();
        $this->assertCount(3, $team->members);
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function aTeamMembersDefaultRoleIsMEMBER()
    {
        /** @var User $user */
        $user = User::factory()->has(Team::factory())->create();
        $this->assertEquals($user->id, $user->teams()->first()->members()->wherePivot('role', 'MEMBER')->first()->id);
        $this->assertCount(0, $user->teams()->first()->members()->wherePivot('role', 'ADMIN')->get());
    }

    /**
     * @return void
     * @test
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function ifATeamIsDeletedThePivotTableShouldBeDeletedToo()
    {
        $team = Team::factory()->has(User::factory(), 'members')->create();
        $this->assertDatabaseCount('team_user', 1);
        $team->delete();
        $this->assertDatabaseCount('team_user', 0);
    }
}
