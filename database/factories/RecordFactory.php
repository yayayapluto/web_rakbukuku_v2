<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use App\Models\Rack;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'record_id' => $this->faker->uuid(),
            'user_id' => User::inRandomOrder()->first()->user_id ?? null, // Use an existing User
            'book_id' => Book::inRandomOrder()->first()->book_id ?? null, // Use an existing Book
            'status' => $this->faker->randomElement(['borrow', 'return', 'none']),
            'borrow_date' => $this->faker->date(),
            'return_date' => $this->faker->date(),
        ];
    }
}
