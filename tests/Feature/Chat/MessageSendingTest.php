<?php

namespace Tests\Feature\Chat;

use Tests\TestCase;
use Acme\Models\User;
use Acme\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageSendingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_send_message()
    {
        $this->signIn();

        // arrange
        $user = create(User::class);

        // act
        $response = $this->postJson(route('messages.store'), [
            'body' => 'Ciao'
        ]);

        // assert
        $this->assertDatabaseHas('messages', ['body' => 'Ciao']);
    }

    /** @test */
    public function when_message_is_sent_an_event_is_raised()
    {
        Event::fake();

        $this->signIn();

        $response = $this->postJson(route('messages.store'), [
            'body' => 'Ciao'
        ]);

        $message = Message::first();

        Event::assertDispatched(MessageSent::class, function ($event) use ($message) {
            return $event->message->id === $message->id && $event->broadcastAs() == 'MessageSent';
        });
    }
}
