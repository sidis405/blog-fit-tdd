<?php

namespace Tests\Feature\Chat;

use Tests\TestCase;
use Acme\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function messages_can_be_listed()
    {
        // arrange
        $messages = create(Message::class, 5);

        // act
        $response = $this->getJson(route('messages.index'));

        // assert
        $messages->map(function ($message) use ($response) {
            $response->assertSee($message->body);
        });

        $response->assertSee($messages->first()->user->name);
    }
}
