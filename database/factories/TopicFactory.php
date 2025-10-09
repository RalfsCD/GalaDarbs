<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory
{
    protected $model = Topic::class;

    public function definition(): array
    {
        return [
            'name'        => ucfirst($this->faker->unique()->words(rand(1, 2), true)),
            'description' => $this->faker->optional(0.6)->sentence(12),
        ];
    }
}
