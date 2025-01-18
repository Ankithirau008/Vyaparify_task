<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Create a related user
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'status' => 'published', // You can set it to 'draft' or 'published'
            'approval_status' => 'approved', // Default approval status
            'featured_image' => 'images/default-placeholder.jpg',
        ];
    }
    
    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            // Attach random categories and tags
            $post->categories()->attach(Category::factory(2)->create());
            $post->tags()->attach(Tag::factory(2)->create());
        });
    }
}
