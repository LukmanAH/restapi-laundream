<?php

namespace Database\Factories;

use App\Models\Catalog;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatalogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Catalog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $icon = array('bucket-outline', 'bed-empty', 'tshirt-crew', 'lingerie', 'rug', 'account-tie');
        $unit = array('kg', 'meter', 'satuan');
        $estimation_type = array('hari', 'jam');
        $price = array(1000, 2000, 3000, 5000);

        return [
            'name' => $this->faker->company(),
            'icon' => $icon[array_rand($icon, 1)],
            'unit' => $unit[array_rand($unit, 1)],
            'price' => $price[array_rand($price, 1)],
            'estimation_complete' => rand(1, 5),
            'estimation_type' => $estimation_type[array_rand($estimation_type, 1)]
        ];
    }
}
