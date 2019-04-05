<?php

namespace Tests\Unit\Chat;

use Tests\TestCase;
use Acme\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function message_belongs_to_a_user()
    {
        $message = create(Message::class);

        $user = $message->user;

        $this->assertInstanceOf('Acme\Models\User', $user);
    }
}
