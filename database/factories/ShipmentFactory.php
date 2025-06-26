<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'user_id'      => \App\Models\User::factory(),
        'tracking_no'  => fake()->unique()->regexify('[A-Z0-9]{10}'),
        'origin'       => fake()->city(),
        'destination'  => fake()->city(),
        'pickup_date'  => fake()->dateTimeBetween('-1 month', 'now'),
        'delivery_date'=> null,
    ];
}

}
