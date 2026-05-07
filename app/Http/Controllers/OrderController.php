<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\OrderChanged;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::all();
        return view('orders', compact('orders'));

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
    public function store(Request $request) {
        $input = $request->validate([
            'name' => ['required'],
            'amount' => ['required', 'int'],
            'bill_no' => ['required'],
        ]);
        $input['user_id'] = Auth::id();
        $order = Order::create($input);
        if(!empty($order)) {
            return redirect("/orders/{$order->id}");
        }
        return back();
    }
}
