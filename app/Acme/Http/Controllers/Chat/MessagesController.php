<?php

namespace Acme\Http\Controllers\Chat;

use Acme\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    public function index()
    {
        return Message::with('user')->latest()->get();
    }

    public function store(Request $request)
    {
        $message = Message::create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        event(new MessageSent($message));

        return $message;
    }
}
