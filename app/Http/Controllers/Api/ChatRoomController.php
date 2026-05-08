<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\StoreChatRoomRequest;
use App\Http\Resources\ChatRoomResource;
use App\Models\ChatRoom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatRoomController extends Controller
{
  
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $rooms = ChatRoom::query()
            ->with(['creator'])
            ->where(function ($q) use ($userId) {
                $q->where('type', 'public')
                  ->orWhere('created_by', $userId)
                  ->orWhereHas('members', fn ($m) => $m->where('users.id', $userId));
            })
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'data' => ChatRoomResource::collection($rooms),
        ]);
    }

   
    public function store(StoreChatRoomRequest $request): JsonResponse
    {
        $room = ChatRoom::create([
            'name'        => $request->string('name'),
            'description' => $request->input('description'),
            'type'        => $request->string('type'),
            'created_by'  => $request->user()->id,
        ]);

        $room->members()->attach($request->user()->id, [
            'joined_at' => now(),
        ]);

        return response()->json([
            'message' => 'Chat room created',
            'data'    => new ChatRoomResource($room->load('creator', 'members')),
        ], 201);
    }

 
    public function show(Request $request, int $id): JsonResponse
    {
        $room = ChatRoom::with(['creator', 'members'])->findOrFail($id);

        if (! $room->isAccessibleBy($request->user())) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json([
            'data' => new ChatRoomResource($room),
        ]);
    }

   
    public function join(Request $request, int $id): JsonResponse
    {
        $room = ChatRoom::findOrFail($id);

        if ($room->type === 'private' && ! $room->isAccessibleBy($request->user())) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $room->members()->syncWithoutDetaching([
            $request->user()->id => ['joined_at' => now()],
        ]);

        return response()->json(['message' => 'Joined']);
    }
}
