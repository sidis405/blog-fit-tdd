<?php

namespace Tests\Feature;

use Tests\TestCase;
use Acme\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function posts_are_listed_in_order()
    {
        // arrange
        $posts = create(Post::class, 10);

        // act
        $response = $this->get(route('posts.index'));

        // assert
        $response->assertSeeInOrder($posts->sortByDesc('created_at')->pluck('title')->toArray());
    }
}
