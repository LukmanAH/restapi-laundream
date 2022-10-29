<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Laundry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'   => User::factory()->create(['role' => User::ROLE_EMPLOYEE]),
            'laundry_id' => Laundry::factory(),
            'status'    => Employee::STATUS_ACTIVE
        ];
    }
}
