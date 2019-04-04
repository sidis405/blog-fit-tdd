<?php

namespace Tests\Unit;

use Tests\TestCase;
use Acme\Models\Post;
use Acme\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_has_many_posts()
    {
        // arrange
        $user = create(User::class);
        $posts = create(Post::class, null, [
            'user_id' => $user->id
        ]);

        // act
        $posts = $user->posts;

        // assert
        $this->assertInstanceOf('Illuminate\Support\Collection', $posts);
        $this->assertInstanceOf('Acme\Models\Post', $posts->first());
    }
}
