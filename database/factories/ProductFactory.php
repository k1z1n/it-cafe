<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imagePath = $this->getRandomImagePath();
        return [
            'title' => $this->faker->word,
            'description' => $this->faker->sentence,
            'structure' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(100, 1000),
            'category_id' => $this->faker->numberBetween(1, 10),
            'image_path' => $imagePath
        ];
    }
    private function getRandomImagePath(): string
    {
        $imageFiles = File::glob(public_path('images/*'));
        $randomImageFile = $imageFiles[array_rand($imageFiles)];

        return str_replace(public_path(), '', $randomImageFile);
    }
}
