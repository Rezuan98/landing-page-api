<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSize;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['product', 'size'])->latest();
        
        // Apply status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Apply date filter
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }
        
        $orders = $query->paginate(20);
        
        return view('backend.orders.index', compact('orders'));
    }

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
    
    public function show($id)
    {
        $order = Order::with(['product', 'size'])->findOrFail($id);
        return view('backend.orders.show', compact('order'));
    }

    /**
     * Update the status of an order.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ]);
        
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;
        
        // If order was cancelled and is now something else, restore inventory
        if ($oldStatus == 'cancelled' && $newStatus != 'cancelled') {
            $this->updateInventory($order->product_id, $order->size_id, -$order->quantity); // Subtract from inventory
        }
        
        // If order is being cancelled, add inventory back
        if ($newStatus == 'cancelled' && $oldStatus != 'cancelled') {
            $this->updateInventory($order->product_id, $order->size_id, $order->quantity); // Add to inventory
        }
        
        $order->status = $newStatus;
        $order->save();
        
        return redirect()->back()->with('success', "Order #{$id} status updated to " . ucfirst($newStatus));
    }
    
    /**
     * Update multiple orders' status at once.
     */
    public function bulkStatusUpdate(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array|min:1',
            'order_ids.*' => 'required|integer|exists:orders,id',
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ]);
        
        $count = 0;
        
        foreach ($request->order_ids as $orderId) {
            $order = Order::find($orderId);
            
            if ($order) {
                $oldStatus = $order->status;
                $newStatus = $request->status;
                
                // Handle inventory adjustments
                if ($oldStatus == 'cancelled' && $newStatus != 'cancelled') {
                    $this->updateInventory($order->product_id, $order->size_id, -$order->quantity);
                }
                
                if ($newStatus == 'cancelled' && $oldStatus != 'cancelled') {
                    $this->updateInventory($order->product_id, $order->size_id, $order->quantity);
                }
                
                $order->status = $newStatus;
                $order->save();
                $count++;
            }
        }
        
        return redirect()->back()->with('success', "{$count} orders updated to " . ucfirst($request->status));
    }
    
    /**
     * Delete an order.
     */
    public function delete($id)
    {
        $order = Order::findOrFail($id);
        
        // If the order status is not cancelled, return inventory
        if ($order->status != 'cancelled') {
            $this->updateInventory($order->product_id, $order->size_id, $order->quantity);
        }
        
        $order->delete();
        
        return redirect()->route('index.order')->with('success', "Order #{$id} deleted successfully");
    }


    private function updateInventory($productId, $sizeId, $quantity)
    {
        $productSize = ProductSize::where('product_id', $productId)
            ->where('size_id', $sizeId)
            ->first();
            
        if ($productSize) {
            $productSize->quantity += $quantity;
            $productSize->save();
        }
    }
}