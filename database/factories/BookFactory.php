<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Rack;
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
    public function definition(): array
    {
        return [
            'book_id' => $this->faker->uuid(),
            'rack_id' => Rack::inRandomOrder()->first()->rack_id ?? null, // Use an existing Rack
            'category_id' => Category::inRandomOrder()->first()->category_id ?? null, // Use an existing Category
            'title' => $this->faker->sentence(3),
            'isbn' => $this->faker->isbn13(),
            'writer' => $this->faker->name(),
            'publisher' => $this->faker->company(),
            'publish_year' => $this->faker->year(),
            'cover' => $this->faker->imageUrl(),
            'soft_file' => $this->faker->filePath(),
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
