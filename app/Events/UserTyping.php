<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class UserTyping implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public User $user,
        public int $chatRoomId,
        public bool $isTyping,
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel("chat.room.presence.{$this->chatRoomId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'user.typing';
    }


    public function broadcastWith(): array
    {
        return [
            'user_id'      => $this->user->id,
            'user_name'    => $this->user->name,
            'chat_room_id' => $this->chatRoomId,
            'is_typing'    => $this->isTyping,
        ];
    }
}
