<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('orders.{orderId}', function(int $orderId = 100) {
    return true;
});
Broadcast::channel('test', fn() => true);