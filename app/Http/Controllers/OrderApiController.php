<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductSize;
use Illuminate\Support\Facades\DB;

class OrderApiController extends Controller
{
    /**
     * Create a new order from frontend
     */
    public function store(Request $request)
    {     

        // $validated = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'phone' => 'required|string|max:20',
            
        //     'address' => 'required|string',
        //     'quantity' => 'required|integer|min:1',
        //     'shipping_option' => 'required|string|in:inside,outside',
        //     'subtotal' => 'required|numeric|min:0',
        //     'shipping_cost' => 'required|numeric|min:0',
        //     'total' => 'required|numeric|min:0',
        //     'product_id' => 'required|exists:products,id',
        //     'size_id' => 'required|exists:sizes,id',
        // ]);

        // Check if there's enough stock for the requested product and size
        $productSize = ProductSize::where('product_id', $request->product_id)
            ->where('size_id', $request->size_id)
            ->first();

        if (!$productSize || $productSize->quantity < $request->quantity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not enough stock available for the selected size.',
            ], 400);
        }

        // Create the order
        $order = Order::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'quantity' => $request->quantity,
            'shipping_option' => $request->shipping_option,
            'subtotal' => $request->subtotal,
            'shipping_cost' => $request->shipping_cost,
            'total' => $request->total,
            'product_id' => $request->product_id,
            'size_id' => $request->size_id,
            'status' => 'pending'
        ]);

        // Reduce the product inventory
        $productSize->quantity -= $request->quantity;
        $productSize->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully!',
            'order' => $order,
        ], 201);
    }
}