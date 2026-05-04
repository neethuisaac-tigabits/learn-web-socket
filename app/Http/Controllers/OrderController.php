<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\OrderPlaced;
use App\Events\OrderChanged;
use App\Models\Order;

class OrderController extends Controller
{
    public function index() {
        $order = Order::first();

        OrderPlaced::dispatch($order);

        return view('orders');

    }
    public function update() {
        $order = Order::first();
        $order->amount += 1;
        $order->save();

        OrderPlaced::dispatch($order);
        OrderChanged::dispatch($order);

        return "done";
    }
}
