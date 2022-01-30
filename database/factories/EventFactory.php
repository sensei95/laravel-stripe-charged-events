<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(rand(2,6));
        $slug = Str::slug($title);

        // $userId = $this->faker->randomElement(User::pluck('id')->toArray());
        $content = $this->faker->sentences(rand(4,6),true);

        return [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'premium' => $this->faker->boolean(25),
            'starts_at' => $this->faker->dateTimeBetween('now','+2 months'),
            'ends_at' => $this->faker->dateTimeBetween('+3 months', '+4 months'),
        ];
    }
}
