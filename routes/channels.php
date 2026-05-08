<?php

use App\Models\ChatRoom;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Private user notification channel (Laravel default)
|--------------------------------------------------------------------------
*/
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/*
|--------------------------------------------------------------------------
| Chat room private channel
|--------------------------------------------------------------------------
| Frontend subscribes to `private-chat.room.{id}`. Returning truthy authorizes.
*/
Broadcast::channel('chat.room.{roomId}', function (User $user, int $roomId) {
    $room = ChatRoom::find($roomId);

    if (! $room) {
        return false;
    }

    return $room->isAccessibleBy($user);
});

/*
|--------------------------------------------------------------------------
| Chat room presence channel
|--------------------------------------------------------------------------
| For presence channels, returning an array becomes the user's "presence info"
| visible to other subscribers via Echo's `.here() / .joining() / .leaving()`.
*/
Broadcast::channel('chat.room.presence.{roomId}', function (User $user, int $roomId) {
    $room = ChatRoom::find($roomId);

    if (! $room || ! $room->isAccessibleBy($user)) {
        return null; // unauthorized
    }

    return [
        'id'   => $user->id,
        'name' => $user->name,
    ];
});

/*
|--------------------------------------------------------------------------
| Pre-existing channels from the orders demo
|--------------------------------------------------------------------------
*/
Broadcast::channel('orders.{order}', function (User $user, Order $order) {
    Log::info('user id in orders channel ' . $user->id);
    Log::info('order id in orders channel ' . $order->id);

    return $user->id === $order->user_id;
});

Broadcast::channel('test', fn () => true);
