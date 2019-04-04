<?php

namespace App\Events;

use Acme\Models\Post;
use Illuminate\Queue\SerializesModels;

class PostWasUpdated
{
    public $post;

    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
