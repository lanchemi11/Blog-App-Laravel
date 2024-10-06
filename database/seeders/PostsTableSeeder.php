<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            Post::create([
                'title' => 'Sample Post Title',
                'content' => 'Sample post content for user ' . $user->name,
                'user_id' => $user->id,
            ]);
        }
    }
}
