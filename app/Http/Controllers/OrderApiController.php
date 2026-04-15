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
     * Create a new order from frontend.
     *
     * Expected request body:
     * {
     *   "name": "...", "phone": "...", "city": "...", "address": "...",
     *   "shipping_option": "inside|outside",
     *   "subtotal": 100.00, "shipping_cost": 10.00, "total": 110.00,
     *   "items": [
     *     { "product_id": 1, "size_id": 2, "quantity": 2, "price": 25.00 },
     *     ...
     *   ]
     * }
     */
    public function store(Request $request)
    {
        $items = $request->input('items', []);

        if (empty($items)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'No items provided.',
            ], 400);
        }

        // Validate stock for all items before touching anything
        $productSizes = [];
        foreach ($items as $index => $item) {
            $productSize = ProductSize::where('product_id', $item['product_id'])
                ->where('size_id', $item['size_id'])
                ->first();

            if (!$productSize) {
                return response()->json([
                    'status'  => 'error',
                    'message' => "Item #" . ($index + 1) . ": product/size combination does not exist.",
                ], 400);
            }

            if ($productSize->quantity < $item['quantity']) {
                return response()->json([
                    'status'  => 'error',
                    'message' => "Item #" . ($index + 1) . ": not enough stock available.",
                ], 400);
            }

            $productSizes[] = $productSize;
        }

        try {
            $order = DB::transaction(function () use ($request, $items, $productSizes) {
                $order = Order::create([
                    'name'            => $request->name,
                    'phone'           => $request->phone,
                    'city'            => $request->city,
                    'address'         => $request->address,
                    'shipping_option' => $request->shipping_option,
                    'subtotal'        => $request->subtotal,
                    'shipping_cost'   => $request->shipping_cost,
                    'total'           => $request->total,
                    'status'          => 'pending',
                ]);

                foreach ($items as $index => $item) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $item['product_id'],
                        'size_id'    => $item['size_id'],
                        'quantity'   => $item['quantity'],
                        'price'      => $item['price'],
                    ]);

                    $productSizes[$index]->quantity -= $item['quantity'];
                    $productSizes[$index]->save();
                }

                return $order->load('items');
            });

            return response()->json([
                'status'  => 'success',
                'message' => 'Order placed successfully!',
                'order'   => $order,
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Order creation failed: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to create order: ' . $e->getMessage(),
            ], 500);
        }
    }
}
