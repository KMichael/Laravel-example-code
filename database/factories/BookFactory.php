<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'edition' => $this->faker->randomElement(['print', 'digital', 'graphic']),
            'user_id' => User::where('is_admin', false)->inRandomOrder()->first()->id, // случайный автор и не админ
        ];
    }
}
