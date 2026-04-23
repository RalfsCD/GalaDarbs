<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [
            ['name' => 'Music 🎵', 'description' => 'All about music and sounds.'],
            ['name' => 'Sports ⚽', 'description' => 'Discuss your favorite sports.'],
            ['name' => 'Movies 🎬', 'description' => 'Talk about films and series.'],
            ['name' => 'Technology 💻', 'description' => 'Latest in tech and gadgets.'],
            ['name' => 'Travel ✈️', 'description' => 'Share travel experiences and tips.'],
            ['name' => 'Food 🍔', 'description' => 'Recipes, restaurants, and more.'],
            ['name' => 'Gaming 🎮', 'description' => 'Video games, board games, and fun.'],
            ['name' => 'Books 📚', 'description' => 'Share and discuss literature.'],
            ['name' => 'Art 🎨', 'description' => 'Everything creative and visual.'],
            ['name' => 'Fitness 🏋️', 'description' => 'Workout routines and health tips.'],
        ];

        foreach ($topics as $topic) {
            Topic::updateOrCreate(['name' => $topic['name']], $topic);
        }
    }
}
