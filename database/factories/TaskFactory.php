<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->optional()->sentence(6),
            'status'      => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            'due_date'    => $this->faker->optional()->date('Y-m-d'),
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
