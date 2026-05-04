<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Order;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('orders.{order}', function(User $user, Order $order) {
    Log::info("user id in orders channel " . $user->id);
    Log::info("order id in orders channel " . $order->id);

    return $user->id === $order->user_id;
});
Broadcast::channel('test', fn() => true);