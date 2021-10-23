<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 500),
            'product_id' => $this->faker->numberBetween(1, 1500),
            'stars' => $this->faker->numberBetween(1, 5),
            'review' => $this->faker->paragraph(),
        ];
    }
}
