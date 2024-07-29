<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Send a message
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'message' => ['required', 'string'],
        ]);

        $message = Message::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return $this->createdResponse('Message sent successfully', $message);
    }


    /**
     * Get all messages
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMessages(): \Illuminate\Http\JsonResponse
    {
        $messages = Message::with('user')->get();

        return $this->successResponse('Messages retrieved successfully', MessageResource::collection($messages));
    }
}
