<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Acme\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostShowingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_a_post()
    {
        // arrange
        $post = create(Post::class);

        // act
        $response = $this->get(route('api.posts.show', $post));

        // assert
        $response->assertHeader('content-type', 'application/json');
        $response->assertJsonStructure([
            'data' => []
        ]);

        $response->assertJsonFragment([
            'id' => $post->id,
            'title' => $post->title,
        ]);

        $response->assertJsonStructure([
            'data' => [
                'title', 'slug', 'category', 'user'
            ],
        ]);
    }
}
