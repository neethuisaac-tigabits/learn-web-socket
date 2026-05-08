<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Events\UserTyping;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\StoreMessageRequest;
use App\Http\Requests\Chat\TypingRequest;
use App\Http\Resources\MessageResource;
use App\Models\ChatRoom;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
  
    public function index(Request $request, int $id): JsonResponse
    {
        $room = ChatRoom::findOrFail($id);

        if (! $room->isAccessibleBy($request->user())) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $perPage = (int) $request->integer('per_page', 30);
        $perPage = max(1, min($perPage, 100));

        $messages = Message::with('user')
            ->where('chat_room_id', $room->id)
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json([
            'data' => MessageResource::collection($messages->items()),
            'meta' => [
                'current_page' => $messages->currentPage(),
                'last_page'    => $messages->lastPage(),
                'per_page'     => $messages->perPage(),
                'total'        => $messages->total(),
            ],
        ]);
    }

 
    public function store(StoreMessageRequest $request, int $id): JsonResponse
    {
        $room = ChatRoom::findOrFail($id);

        if (! $room->isAccessibleBy($request->user())) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $message = Message::create([
            'chat_room_id' => $room->id,
            'user_id'      => $request->user()->id,
            'message'      => $request->string('message'),
        ]);

        $message->load('user');

    
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message' => 'Sent',
            'data'    => new MessageResource($message),
        ], 201);
    }

   
    public function typing(TypingRequest $request, int $id): JsonResponse
    {
        $room = ChatRoom::findOrFail($id);

        if (! $room->isAccessibleBy($request->user())) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        broadcast(new UserTyping(
            $request->user(),
            $room->id,
            (bool) $request->boolean('is_typing'),
        ))->toOthers();

        return response()->json(['message' => 'ok']);
    }
}
