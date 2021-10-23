<?php

namespace Database\Factories;

use App\Models\Product;
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
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph(5),
            'unit' => $this->faker->randomElement(['kilogram', 'quantity', 'meter']),
            'price'=>$this->faker->randomFloat(2,10,500),
            'total'=>$this->faker->numberBetween(2,250),
            'category_id'=>$this->faker->numberBetween(1,50),

            //
        ];
    }
}
