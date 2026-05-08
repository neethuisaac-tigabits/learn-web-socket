<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Order::query()->orderByDesc('id')->get(),
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $order = Order::query()->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['data' => $order]);
    }

    public function increment(Request $request, int $id): JsonResponse
    {
        $order = Order::query()->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->amount = (int) $order->amount + 1;
        $order->save();

        return response()->json([
            'message' => 'ok',
            'data' => $order,
        ]);
    }
}

