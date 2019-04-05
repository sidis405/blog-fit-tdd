<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Acme\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_post_listing()
    {
        // arrange
        $posts = create(Post::class, 10);

        // act
        $response = $this->get(route('api.posts.index'));

        // assert
        // verificare che è json
        $response->assertHeader('content-type', 'application/json');
        $response->assertJsonStructure([
            'data' => []
        ]);

        // ciclare i post e verifichiamo che che siano nel corpo della risposta
        foreach ($posts as $post) {
            $response->assertJsonFragment([
                'id' => $post->id,
                'title' => $post->title,
            ]);
        }

        $response->assertJsonStructure([
            'data' => [
                [ 'title', 'slug', 'category', 'user' ]
            ],
        ]);



        $response->assertJsonMissing(['category_id', 'user_id']);
    }
}
