<?php

namespace App\Listeners;

use App\Jobs\SendUpdateEmail;
use App\Events\PostWasUpdated;

class SendEmailForUpdatedPostListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PostWasUpdated $event)
    {
        SendUpdateEmail::dispatch($event->post);
    }
}
