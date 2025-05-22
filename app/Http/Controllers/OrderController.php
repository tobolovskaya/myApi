<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::all());
    }

    public function store(Request $request)
    {
        $order = Order::createOrder($request->all());
        if (!$order) {
            return response()->json(['error' => 'Product out of stock'], 400);
        }
        return response()->json($order, 201);
    }

    public function show(Order $order)
    {
        return response()->json($order->getInfo());
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        $order->cancel();
        return response()->json(['message' => 'Order cancelled and deleted.']);
    }
    //
}
