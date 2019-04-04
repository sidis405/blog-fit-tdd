<?php

namespace Tests\Feature;

use Tests\TestCase;
use Acme\Models\Post;
use Acme\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_post_creation_form()
    {
        $this->signIn();

        $response = $this->get(route('posts.create'));

        $response->assertOk();
        $response->assertViewIs('posts.create');
        $response->assertSee('Create a new post');
    }

    /** @test */
    public function user_can_create_post()
    {
        $this->signIn();

        // $postData = factory(Post::class)->make([
        //     'user_id' => $user->id
        // ])->toArray();

        // $postData = factory(Post::class)->make()->only(
        //     'category_id',
        //     'title',
        //     'slug'
        // );

        $postData = make(Post::class, null, ['user_id' => auth()->id()])->toArray();
        unset($postData['created_at']);

        $response = $this->post(route('posts.store'), $postData);

        $this->assertDatabaseHas('posts', $postData);
        $response->assertRedirect(route('posts.show', Post::first()));
    }

    /** @test */
    public function posts_has_mandatory_fields()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $response = $this->post(route('posts.store'), []);

        $response->assertSessionHasErrors(['title']);
        $response->assertSessionHasErrors(['category_id']);
    }

    /** @test */
    public function guest_users_cannot_see_post_creation_form()
    {
        $this->withExceptionHandling();
        $response = $this->get(route('posts.create'));

        $response->assertRedirect(route('login'));
    }


    /** @test */
    public function guest_users_cannot_save_new_posts()
    {
        $this->withExceptionHandling();

        $response = $this->post(route('posts.store'), []);

        $response->assertRedirect(route('login'));
    }
}
