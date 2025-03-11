@extends('backend.dashboard')

@section('KEYTITLE', 'Order Details')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Order #{{ $order->id }}</h4>
                <div>
                    <a href="{{ route('index.order') }}" class="btn btn-outline-secondary">
                        <i data-feather="arrow-left" class="icon-sm me-1"></i> Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Status Card -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Status</h5>
                </div>
                <div class="card-body text-center">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-3">
                            <span class="badge bg-@if($order->status == 'pending')warning
                                            @elseif($order->status == 'processing')info
                                            @elseif($order->status == 'shipped')primary
                                            @elseif($order->status == 'delivered')success
                                            @elseif($order->status == 'cancelled')danger
                                            @else secondary @endif p-2" style="font-size: 1rem;">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="text-muted mb-3">Last updated: {{ $order->updated_at->format('M d, Y H:i') }}</p>

                        <!-- Status Update Form -->
                        <form action="{{ route('order.update-status', $order->id) }}" method="POST" class="w-100">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="status" class="text-start d-block mb-2">Change Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="pending" @if($order->status == 'pending') selected @endif>Pending</option>
                                    <option value="processing" @if($order->status == 'processing') selected @endif>Processing</option>
                                    <option value="shipped" @if($order->status == 'shipped') selected @endif>Shipped</option>
                                    <option value="delivered" @if($order->status == 'delivered') selected @endif>Delivered</option>
                                    <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="fw-bold mb-1">Name</p>
                        <p>{{ $order->name }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="fw-bold mb-1">Phone</p>
                        <p>{{ $order->phone }}</p>
                    </div>
                    <div>
                        <p class="fw-bold mb-1">Shipping Address</p>
                        <p>{{ $order->address }}</p>
                    </div>
                    <div>
                        <p class="fw-bold mb-1">Shipping Option</p>
                        <p>{{ ucfirst($order->shipping_option) }} City</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <p>Subtotal</p>
                        <p>${{ number_format($order->subtotal, 2) }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p>Shipping Cost</p>
                        <p>${{ number_format($order->shipping_cost, 2) }}</p>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <p class="fw-bold">Total</p>
                        <p class="fw-bold">${{ number_format($order->total, 2) }}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Order Date</p>
                        <p>{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        @if($order->product)
                                        <div class="d-flex align-items-center">
                                            @if($order->product->images->where('is_primary', true)->first())
                                            <img src="{{ asset('storage/' . $order->product->images->where('is_primary', true)->first()->image_path) }}" alt="{{ $order->product->name }}" class="me-2" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                            @endif
                                            <div>
                                                <p class="mb-0 fw-medium">{{ $order->product->name }}</p>
                                                <p class="mb-0 text-muted small">{{ $order->product->brand->name }}</p>
                                            </div>
                                        </div>
                                        @else
                                        <span class="text-muted">Product not found</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->size)
                                        {{ $order->size->size }}
                                        @else
                                        <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>
                                        @if($order->product)
                                        ${{ number_format($order->subtotal / $order->quantity, 2) }}
                                        @else
                                        <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Shipping:</td>
                                    <td>${{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold">${{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <a href="{{ route('index.order') }}" class="btn btn-outline-secondary">
                    <i data-feather="arrow-left" class="icon-sm me-1"></i> Back to Orders
                </a>
                <div>
                    <a href="#" class="btn btn-outline-primary me-2" onclick="window.print()">
                        <i data-feather="printer" class="icon-sm me-1"></i> Print Order
                    </a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteOrderModal">
                        <i data-feather="trash-2" class="icon-sm me-1"></i> Delete Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Order Confirmation Modal -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete Order #{{ $order->id }}? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('order.delete', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete Order</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
