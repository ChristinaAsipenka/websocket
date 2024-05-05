<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\Message\MessageResourse;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messagesAll = Message::latest()->get();
        $messages = MessageResourse::collection($messagesAll)->resolve();

        return inertia('Message/index', compact('messages'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $message = Message::create($data);
        event(new StoreMessageEvent($message));

        return MessageResourse::make($message)->resolve();
    }
}
