<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->paragraph()
        ];
    }

    public function due(DateTime $dateTime): TaskFactory
    {
        return $this->state(function () use ($dateTime) {
            return [
                'due' => $dateTime
            ];
        });
    }
}
