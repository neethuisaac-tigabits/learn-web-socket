<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use App\Models\Order;


class OrderChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    
    public function __construct(
        public Order $order
    )
    {
        Log::info("OrderChanged event created");
    }

    
    public function broadcastOn(): array
    {
        Log::info("broadcastOn method called for OrderChanged");
        return [
            new PrivateChannel('orders.' . $this->order->id),
            new PresenceChannel('test.' . $this->order->id),
            new Channel('updates'),
        ];
    }
}

 /*
  * 
  * 
  * 
  * 
  * 
  * 
  * 
  * 
  * 
  * 
  */