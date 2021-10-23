<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'user_id' => $this->faker->numberBetween(1, 500),
            'order_id' => $this->faker->numberBetween(1, 50),
            'title' => $this->faker->sentence,
            'message' => $this->faker->paragraph(6),
            'status' => $this->faker->randomElement(['pending', 'closed', 'waiting']),
            'ticket_type_id' => $this->faker->numberBetween(1, 4),



        ];
    }
}
