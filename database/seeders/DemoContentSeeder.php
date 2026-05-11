<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Group;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@test.lv'],
            [
                'name' => 'Administrators',
                'password' => Hash::make('Parole123!'),
                'role' => 'admin',
            ]
        );

        $users = collect([
            $admin,
            User::updateOrCreate(['email' => 'alise@test.lv'], ['name' => 'Alise', 'password' => Hash::make('Demo123!')]),
            User::updateOrCreate(['email' => 'janis@test.lv'], ['name' => 'Janis', 'password' => Hash::make('Demo123!')]),
            User::updateOrCreate(['email' => 'eva@test.lv'], ['name' => 'Eva', 'password' => Hash::make('Demo123!')]),
            User::updateOrCreate(['email' => 'martins@test.lv'], ['name' => 'Martins', 'password' => Hash::make('Demo123!')]),
            User::updateOrCreate(['email' => 'laura@test.lv'], ['name' => 'Laura', 'password' => Hash::make('Demo123!')]),
        ]);

        // add some additional random users to populate likes/comments
        $extra = User::factory()->count(12)->create();
        $users = $users->concat($extra)->values();

        // prepare faker and download profile photos for users (if missing)
        $faker = \Faker\Factory::create();

        // download profile photos for users (if missing)
        foreach ($users as $user) {
            if (empty($user->profile_photo_path)) {
                $url = 'https://i.pravatar.cc/300?u=' . urlencode($user->email);
                $path = $this->downloadToStorage($url, 'avatars');
                if ($path) {
                    $user->update(['profile_photo_path' => $path]);
                }
            }
        }

        $topics = Topic::query()->orderBy('id')->get();

        // create ~10 group definitions for lively demo content
        $groupDefinitions = [
            ['name' => 'Weekend Beats', 'description' => 'New music drops, concert tips, and playlist swaps.'],
            ['name' => 'Pitch Side', 'description' => 'Sports talk, match reactions, and predictions.'],
            ['name' => 'Frame Club', 'description' => 'Movies, series, and standout scenes worth discussing.'],
            ['name' => 'Build Mode', 'description' => 'Tech, apps, tools, and the latest releases.'],
            ['name' => 'Road Notes', 'description' => 'Travel stories, routes, and destination advice.'],
            ['name' => 'Table Talk', 'description' => 'Food finds, recipes, and local restaurant recommendations.'],
            ['name' => 'Level Up', 'description' => 'Gaming communities, tips, and co-op plans.'],
            ['name' => 'Page Turners', 'description' => 'Books, authors, and what people are reading right now.'],
            ['name' => 'Green Thumb', 'description' => 'Gardening tips, plant swaps, and seasonal care.'],
            ['name' => 'City Sketches', 'description' => 'Local photography, urban life, and hidden gems.'],
        ];

        $groupModels = [];

        foreach ($groupDefinitions as $index => $definition) {
            $creator = $users[$index % $users->count()];

            $group = Group::updateOrCreate(
                ['name' => $definition['name']],
                [
                    'description' => $definition['description'],
                    'creator_id' => $creator->id,
                ]
            );

            $topicIds = $topics->slice($index % max($topics->count(), 1), 2)->pluck('id');
            if ($topicIds->isEmpty() && $topics->isNotEmpty()) {
                $topicIds = $topics->take(2)->pluck('id');
            }

            $group->topics()->syncWithoutDetaching($topicIds->all());
            $group->members()->syncWithoutDetaching($users->pluck('id')->take(4 + ($index % 2))->all());

            $groupModels[] = $group->fresh(['topics', 'members']);
        }

        foreach ($groupModels as $index => $group) {
            // create several posts per group with optional images
            $postCount = rand(2, 5);
            for ($p = 0; $p < $postCount; $p++) {
                $author = $users[array_rand($users->toArray())];
                $title = $p === 0 ? ($group->name . ' weekly thread') : Str::limit($this->randomTitle($group->name), 60);

                $attachImage = rand(1, 100) <= 40; // 40% chance
                $mediaPath = null;
                if ($attachImage) {
                    $seed = Str::slug($group->name) . '-' . $p . '-' . rand(1, 9999);
                    $url = 'https://picsum.photos/seed/' . $seed . '/1200/800';
                    $mediaPath = $this->downloadToStorage($url, 'posts');
                }

                $post = Post::create([
                    'group_id' => $group->id,
                    'user_id' => $author->id,
                    'title' => $title,
                    'content' => $faker->paragraphs(rand(1, 4), true),
                    'media_path' => $mediaPath,
                ]);

                // add random comments
                $commentCount = rand(0, 6);
                for ($c = 0; $c < $commentCount; $c++) {
                    $commentUser = $users[array_rand($users->toArray())];
                    Comment::create([
                        'post_id' => $post->id,
                        'user_id' => $commentUser->id,
                        'content' => $faker->sentences(rand(1, 3), true),
                    ]);
                }

                // add random likes
                $likeCount = rand(0, min(8, $users->count()));
                if ($likeCount > 0) {
                    $likeUsers = $users->random($likeCount)->pluck('id')->all();
                    $post->likes()->syncWithoutDetaching($likeUsers);
                }
            }
        }
    }

    private function downloadToStorage(string $url, string $folder): ?string
    {
        try {
            $contents = @file_get_contents($url);
            if ($contents === false) {
                return null;
            }

            $filename = $folder . '/' . Str::random(12) . '.jpg';
            Storage::disk('public')->put($filename, $contents);
            return $filename;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function randomTitle(string $groupName): string
    {
        $verbs = ['Discussing', 'Thoughts on', 'Best of', 'New', 'Top', 'Quick take:'];
        return $verbs[array_rand($verbs)] . ' ' . $groupName . ' — ' . Str::title(\Faker\Factory::create()->words(rand(1, 3), true));
    }
}