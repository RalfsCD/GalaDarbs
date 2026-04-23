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

        $topics = Topic::query()->orderBy('id')->get();

        $groupDefinitions = [
            ['name' => 'Weekend Beats', 'description' => 'New music drops, concert tips, and playlist swaps.'],
            ['name' => 'Pitch Side', 'description' => 'Sports talk, match reactions, and predictions.'],
            ['name' => 'Frame Club', 'description' => 'Movies, series, and standout scenes worth discussing.'],
            ['name' => 'Build Mode', 'description' => 'Tech, apps, tools, and the latest releases.'],
            ['name' => 'Road Notes', 'description' => 'Travel stories, routes, and destination advice.'],
            ['name' => 'Table Talk', 'description' => 'Food finds, recipes, and local restaurant recommendations.'],
            ['name' => 'Level Up', 'description' => 'Gaming communities, tips, and co-op plans.'],
            ['name' => 'Page Turners', 'description' => 'Books, authors, and what people are reading right now.'],
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
            $primaryAuthor = $users[$index % $users->count()];
            $secondaryAuthor = $users[($index + 1) % $users->count()];

            $postA = Post::updateOrCreate(
                [
                    'group_id' => $group->id,
                    'title' => $group->name . ' weekly thread',
                ],
                [
                    'user_id' => $primaryAuthor->id,
                    'content' => 'A fresh demo post to make the feed feel alive with real conversation starters.',
                    'media_path' => null,
                ]
            );

            $postB = Post::updateOrCreate(
                [
                    'group_id' => $group->id,
                    'title' => 'Quick take: ' . Str::limit($group->name, 24, ''),
                ],
                [
                    'user_id' => $secondaryAuthor->id,
                    'content' => 'Short demo content keeps the homepage from looking empty on first load.',
                    'media_path' => null,
                ]
            );

            foreach ([$postA, $postB] as $post) {
                Comment::updateOrCreate(
                    [
                        'post_id' => $post->id,
                        'user_id' => $users[($index + 2) % $users->count()]->id,
                        'content' => 'Looks good. This is exactly the kind of demo activity the app needs.',
                    ],
                    []
                );

                Comment::updateOrCreate(
                    [
                        'post_id' => $post->id,
                        'user_id' => $users[($index + 3) % $users->count()]->id,
                        'content' => 'I would join this conversation immediately.',
                    ],
                    []
                );

                DB::table('post_likes')->updateOrInsert(
                    ['post_id' => $post->id, 'user_id' => $admin->id],
                    ['created_at' => now(), 'updated_at' => now()]
                );

                DB::table('post_likes')->updateOrInsert(
                    ['post_id' => $post->id, 'user_id' => $users[($index + 4) % $users->count()]->id],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}