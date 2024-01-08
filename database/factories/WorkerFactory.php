<?php

namespace Database\Factories;

use App\Models\Worker;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Worker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_worker' => $this->faker->randomNumber(5, true),
            'name' => $this->faker->name(),
            'department_id' => function() {
                return Department::all()->random();
            }
        ];
    }
}
