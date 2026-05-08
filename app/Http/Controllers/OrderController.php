<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\OrderChanged;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request) {

        $orders = Order::where('user_id', $request->user()->id)->get();

        if($request->is('api*')) {
            return response()->json($orders, 200);
        }
        
        return view('orders', compact('orders'));

    }
    public function update(Request $request, $id) {

        $order = Order::find($id);
        $order->amount += 1;
        $order->save();

        OrderChanged::dispatch($order);

        if($request->is('api*')) {
            return response()->json($order, 200);
        }
        else {
            return "done {$order->amount}";
        }
    }
    public function show (Request $request, $id) {

        $order = Order::where('id', $id)->where('user_id', $request->user()->id)->first();

        if($request->is('api*')) {
            return response()->json($order, 200);
        }
        else {
            return view('order',  compact('order'));
        }
    }   
    public function store(Request $request) {

        $input = $request->validate([
            'name' => ['required'],
            'amount' => ['required', 'int'],
            'bill_no' => ['required'],
        ]);

        $input['user_id'] = Auth::id();
        $order = Order::create($input);
        if($request->is('api*')) {
            return response()->json($order, 200);
        }
        else {
            if(!empty($order)) {
                return redirect("/orders/{$order->id}");
            }
            return back();
        }
    }
}
