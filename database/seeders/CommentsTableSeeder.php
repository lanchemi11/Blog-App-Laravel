<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            Comment::create([
                'content' => 'This is a sample comment for post ' . $post->title,
                'post_id' => $post->id,
                'user_id' => $post->user_id,
            ]);
        }
    }
}
