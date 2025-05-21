<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $admin = Admin::factory()->create();
        $category = Category::factory()->create();
        return [
            'title' => $this->faker->sentence(), // Random title
            'slug' => $this->faker->slug(), // Random slug based on the title
            'body' => $this->faker->paragraphs(rand(3, 5), true), // Random content with multiple paragraphs
            'excerpt' => $this->faker->text(100), // Random excerpt text
            'category_id' => $category->id, // Use a related Category factory
            'admin_id' => $admin->id, // Assuming you want to link to a related Admin factory
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']), // Random status
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Random published date within the last year
            'meta_description' => $this->faker->text(150), // Random meta description
            'meta_keywords' => implode(',', $this->faker->words(5)), // Random keywords
            'featured_image' => json_encode($this->faker->imageUrl()), // Random image URL
            'is_trending' => $this->faker->boolean(30), // 30% chance of being true
            'is_featured' => $this->faker->boolean(20), // 20% chance of being true
            'is_top' => $this->faker->boolean(10), // 10% chance of being true
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),

        ];
    }

}
