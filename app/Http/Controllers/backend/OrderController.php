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
        $query = Order::with(['items.product', 'items.size'])->latest();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->paginate(20);

        return view('backend.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product.images', 'items.product.brand', 'items.size'])->findOrFail($id);
        return view('backend.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::with('items')->findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
            $this->adjustInventoryForOrder($order, -1); // restore: subtract back
        }

        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            $this->adjustInventoryForOrder($order, 1); // cancel: add back
        }

        $order->status = $newStatus;
        $order->save();

        return redirect()->back()->with('success', "Order #{$id} status updated to " . ucfirst($newStatus));
    }

    public function bulkStatusUpdate(Request $request)
    {
        $request->validate([
            'order_ids'   => 'required|array|min:1',
            'order_ids.*' => 'required|integer|exists:orders,id',
            'status'      => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $newStatus = $request->status;
        $orders = Order::with('items')->whereIn('id', $request->order_ids)->get();

        foreach ($orders as $order) {
            if ($order->status === 'cancelled' && $newStatus !== 'cancelled') {
                $this->adjustInventoryForOrder($order, -1);
            } elseif ($newStatus === 'cancelled' && $order->status !== 'cancelled') {
                $this->adjustInventoryForOrder($order, 1);
            }
        }

        Order::whereIn('id', $orders->pluck('id'))->update(['status' => $newStatus]);

        $count = $orders->count();

        return redirect()->back()->with('success', "{$count} orders updated to " . ucfirst($newStatus));
    }

    public function delete($id)
    {
        $order = Order::with('items')->findOrFail($id);

        if ($order->status !== 'cancelled') {
            $this->adjustInventoryForOrder($order, 1); // add stock back
        }

        $order->delete();

        return redirect()->route('index.order')->with('success', "Order #{$id} deleted successfully");
    }

    /**
     * Adjust inventory for every item in an order.
     * $multiplier = 1  → add quantity back to stock (cancel / delete)
     * $multiplier = -1 → remove quantity from stock (un-cancel)
     */
    private function adjustInventoryForOrder(Order $order, int $multiplier)
    {
        foreach ($order->items as $item) {
            $productSize = ProductSize::where('product_id', $item->product_id)
                ->where('size_id', $item->size_id)
                ->first();

            if ($productSize) {
                $productSize->quantity += $multiplier * $item->quantity;
                $productSize->save();
            }
        }
    }
}
