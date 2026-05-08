<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Message $message)
    {
        $this->message->loadMissing('user');
    }

   
     
    public function broadcastOn(): array
    {
        $roomId = $this->message->chat_room_id;

        return [
            new Channel("chat.room.public.{$roomId}"),
            new PrivateChannel("chat.room.{$roomId}"),
            new PresenceChannel("chat.room.presence.{$roomId}"),
        ];
    }

   
    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    
    public function broadcastWith(): array
    {
        return [
            'id'           => $this->message->id,
            'chat_room_id' => $this->message->chat_room_id,
            'user_id'      => $this->message->user_id,
            'message'      => $this->message->message,
            'user'         => [
                'id'   => $this->message->user->id,
                'name' => $this->message->user->name,
            ],
            'created_at'   => $this->message->created_at?->toISOString(),
        ];
    }
}
