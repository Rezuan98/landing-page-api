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
        try {
            // Fetch the product size record before using it
            $productSize = \App\Models\ProductSize::where('product_id', $request->product_id)
                        ->where('size_id', $request->size_id)
                        ->first();
            
            // Check if the product size exists
            if (!$productSize) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The requested product size combination does not exist.'
                ], 400);
            }
            
            // Check if there's enough stock
            if ($productSize->quantity < $request->quantity) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Not enough stock available for the selected size.'
                ], 400);
            }
            
            // Create the order
            $order = \App\Models\Order::create([
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
    
            // Now update the inventory
            $productSize->quantity -= $request->quantity;
            $productSize->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Order placed successfully!',
                'order' => $order,
            ], 201);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Order creation failed: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }
}