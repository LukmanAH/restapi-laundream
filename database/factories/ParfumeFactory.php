<?php

namespace Database\Factories;

use App\Models\Laundry;
use App\Models\Parfume;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParfumeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Parfume::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $parfume = ['Rinso', 'Molto', 'Daia', 'Attack'];
        return [
            'name' => $parfume[array_rand($parfume, 1)],
            'laundry_id' => Laundry::factory()
        ];
    }
}
