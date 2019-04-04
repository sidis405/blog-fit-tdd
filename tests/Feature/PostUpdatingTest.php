<?php

namespace Tests\Feature;

use Tests\TestCase;
use Acme\Models\Post;
use App\Jobs\SendUpdateEmail;
use App\Events\PostWasUpdated;
use App\Mail\APostWasUpdatedEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostUpdatingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_see_update_form()
    {
        $this->withExceptionHandling();

        $post = create(Post::class);

        $respose = $this->get(route('posts.edit', $post));

        $respose->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannnot_update_post()
    {
        $this->withExceptionHandling();

        $post = create(Post::class);

        $respose = $this->patch(route('posts.update', $post), []);

        $respose->assertRedirect(route('login'));
    }

    // /** @test */
    // public function user_can_see_update_form()
    // {
    //     //
    // }

    /** @test */
    public function user_can_update_post()
    {
        $this->updateRandomPost();

        // update
        $this->assertDatabaseHas('posts', [
            'title' => 'Updated title'
        ]);
    }

    public function updateRandomPost()
    {
        // arrange
        $this->signIn();
        $post = create(Post::class, null, ['user_id' => auth()->id()]);

        // act
        $respose = $this->patch(route('posts.update', $post), [
            'title' => 'Updated title'
        ]);

        return $post;
    }

    ///////////////

    /** @test */
    public function when_post_is_updated_custom_event_is_fired()
    {
        Event::fake();

        $post = $this->updateRandomPost();

        // Event::assertDispatched(PostWasUpdated::class);
        Event::assertDispatched(PostWasUpdated::class, function ($event) use ($post) {
            return $event->post->id === $post->id;
        });
    }

    /** @test */
    public function when_post_is_updated_job_to_send_email_is_queued_up()
    {
        Queue::fake();

        $post = $this->updateRandomPost();

        // Queue::assertPushed(SendUpdateEmail::class);
        Queue::assertPushed(SendUpdateEmail::class, function ($job) use ($post) {
            return $job->post->id === $post->id;
        });
    }

    /** @test */
    public function when_posts_is_updated_an_email_is_sent()
    {
        Mail::fake();

        $post = $this->updateRandomPost();

        // Mail::assertSent(APostWasUpdatedEmail::class);
        Mail::assertSent(APostWasUpdatedEmail::class, function ($mail) use ($post) {
            $mail->build();
            return $mail->hasTo($post->user->email) && $mail->subject == 'Yo a post was updated';
        });
    }
}
