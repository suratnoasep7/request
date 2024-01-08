<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Location;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_product' => $this->faker->numerify('PR-#####'),
            'name' => $this->faker->word(),
            'location_id' => function() {
                return Location::all()->random();
            },
            'unit_id' => function() {
                return Unit::all()->random();
            },
            'stock' => $this->faker->randomNumber(2)
        ];
    }
}
