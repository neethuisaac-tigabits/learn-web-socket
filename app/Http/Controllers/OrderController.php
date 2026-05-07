<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\OrderChanged;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index() {
        $order = Order::first();

        OrderPlaced::dispatch($order);

        return view('orders');

    }
    public function update(Request $request, $id) {
        $order = Order::find($id);
        $order->amount += 1;
        $order->save();

        OrderChanged::dispatch($order);

        return "done {$order->amount}";
    }
    public function show (Request $request, $id) {
        Log::info("id passed in order show request " . $id  . " and path : " . request()->fullUrl());
        $order = Order::find($id);

        return view('order',  compact('order'));
    }   
}
