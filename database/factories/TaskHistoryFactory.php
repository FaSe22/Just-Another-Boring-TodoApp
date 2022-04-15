<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    /**
     * @param string $state
     * @return TaskHistoryFactory
     * @author Sebastian Faber <sebastian@startup-werk.de>
     */
    public function status(string $state): TaskHistoryFactory
    {
        return $this->state(function () use ($state) {
            return [
                'state' => $state
            ];
        });
    }
}
