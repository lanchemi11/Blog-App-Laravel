<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class PostUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_post_page_displays_content()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/posts/' . $post->id);

        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->content);
    }
}
