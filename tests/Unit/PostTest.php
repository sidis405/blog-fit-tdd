<?php

namespace Tests\Unit;

use Tests\TestCase;
use Acme\Models\Tag;
use Acme\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function posts_belongs_to_a_user()
    {
        // arrange
        $post = create(Post::class);

        // act
        $user = $post->user;

        // assert
        $this->assertInstanceOf('Acme\Models\User', $user);
    }

    /** @test */
    public function post_belongs_to_a_category()
    {
        // arrange
        $post = create(Post::class);

        // act
        $category = $post->category;

        // assert
        $this->assertInstanceOf('Acme\Models\Category', $category);
    }

    /** @test */
    public function post_has_many_tags()
    {
        // arrange
        $post = create(Post::class);
        $post->tags()->sync(create(Tag::class, 3));

        // act
        $tags = $post->tags;

        // assert
        $this->assertInstanceOf('Acme\Models\Tag', $tags->first());
        $this->assertInstanceOf('Illuminate\Support\Collection', $tags);
    }

    /** @test */
    public function post_is_identified_by_slug()
    {
        $post = create(Post::class);
        // $this->assertEquals(route('posts.show', $post), config('app.url') . '/posts/' . $post->slug);
        $this->assertEquals($post->getRouteKeyName(), 'slug');
    }

    /** @test */
    public function post_creates_own_slug()
    {
        $post = create(Post::class);

        $this->assertEquals($post->slug, Str::slug($post->title));
    }
}
