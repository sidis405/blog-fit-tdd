<?php

namespace Tests\Feature;

use Tests\TestCase;
use Acme\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostShowingTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_see_single_post()
    {
        // arrange
        $post = create(Post::class);
        // act
        $response = $this->get(route('posts.show', $post));

        // assert
        $response->assertStatus(200);
        $response->assertSee($post->title);
    }
}
