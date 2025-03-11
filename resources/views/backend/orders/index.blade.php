@extends('backend.dashboard')

@section('KEYTITLE', 'Manage Orders')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">All Orders</h4>
                        <div>
                            <button id="bulkStatusBtn" class="btn btn-primary" disabled>Update Selected Orders</button>
                        </div>
                    </div>

                    <!-- Bulk Status Update Form -->
                    <form id="bulkStatusForm" action="{{ route('order.bulk-status-update') }}" method="POST" class="mb-4 d-none">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label for="bulk_status" class="form-label">Change Status</label>
                                <select class="form-select" id="bulk_status" name="status">
                                    <option value="" selected disabled>Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success">Update Orders</button>
                                <button type="button" id="cancelBulkUpdate" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </div>
                        <div id="selectedOrdersContainer"></div>
                    </form>

                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="statusFilter" class="form-label">Filter by Status</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="dateFilter" class="form-label">Filter by Date</label>
                            <input type="date" class="form-control" id="dateFilter">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button id="applyFilters" class="btn btn-sm btn-outline-primary me-2">Apply Filters</button>
                            <button id="clearFilters" class="btn btn-sm btn-outline-secondary">Clear</button>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input order-checkbox" type="checkbox" value="{{ $order->id }}" id="order{{ $order->id }}">
                                        </div>
                                    </td>
                                    <td>#{{ $order->id }}</td>
                                    <td>
                                        <div>{{ $order->name }}</div>
                                        <small class="text-muted">{{ $order->phone }}</small>
                                    </td>
                                    <td>
                                        @if($order->product)
                                        {{ $order->product->name }}
                                        @else
                                        <span class="text-muted">N/A</span>
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
                                    <td>${{ $order->total }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm dropdown-toggle status-dropdown
                                                @if($order->status == 'pending') btn-warning
                                                @elseif($order->status == 'processing') btn-info
                                                @elseif($order->status == 'shipped') btn-primary
                                                @elseif($order->status == 'delivered') btn-success
                                                @elseif($order->status == 'cancelled') btn-danger
                                                @else btn-secondary @endif
                                            " type="button" data-bs-toggle="dropdown">
                                                {{ ucfirst($order->status) }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <form action="{{ route('order.update-status', $order->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="pending">
                                                        <button type="submit" class="dropdown-item">Pending</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('order.update-status', $order->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="processing">
                                                        <button type="submit" class="dropdown-item">Processing</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('order.update-status', $order->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="shipped">
                                                        <button type="submit" class="dropdown-item">Shipped</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('order.update-status', $order->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="delivered">
                                                        <button type="submit" class="dropdown-item">Delivered</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form action="{{ route('order.update-status', $order->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="dropdown-item text-danger">Cancelled</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-info me-1">
                                            <i data-feather="eye" class="icon-sm"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger delete-order" data-id="{{ $order->id }}">
                                            <i data-feather="trash" class="icon-sm"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <p class="text-muted mb-0">No orders found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-3">
                        {{ $orders->links() }}
                    </div>
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
                Are you sure you want to delete this order? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteOrderForm" action="" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete Order</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        // Handle Select All checkbox
        $('#selectAll').on('change', function() {
            $('.order-checkbox').prop('checked', $(this).is(':checked'));
            updateBulkActionButton();
        });

        // Handle individual checkboxes
        $('.order-checkbox').on('change', function() {
            updateBulkActionButton();

            // If any checkbox is unchecked, uncheck "Select All" as well
            if (!$(this).is(':checked')) {
                $('#selectAll').prop('checked', false);
            }
            // If all checkboxes are checked, check "Select All" as well
            else if ($('.order-checkbox:checked').length === $('.order-checkbox').length) {
                $('#selectAll').prop('checked', true);
            }
        });

        // Enable/disable bulk action button based on checkbox selection
        function updateBulkActionButton() {
            const hasChecked = $('.order-checkbox:checked').length > 0;
            $('#bulkStatusBtn').prop('disabled', !hasChecked);
        }

        // Show bulk update form
        $('#bulkStatusBtn').on('click', function() {
            $('#bulkStatusForm').removeClass('d-none');
            $(this).addClass('d-none');

            // Create hidden inputs for selected order IDs
            const selectedOrders = $('.order-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            $('#selectedOrdersContainer').empty();

            selectedOrders.forEach(function(orderId) {
                $('#selectedOrdersContainer').append(
                    `<input type="hidden" name="order_ids[]" value="${orderId}">`
                );
            });
        });

        // Hide bulk update form
        $('#cancelBulkUpdate').on('click', function() {
            $('#bulkStatusForm').addClass('d-none');
            $('#bulkStatusBtn').removeClass('d-none');
        });

        // Delete order confirmation
        $('.delete-order').on('click', function() {
            const orderId = $(this).data('id');
            $('#deleteOrderForm').attr('action', `/order/delete/${orderId}`);
            $('#deleteOrderModal').modal('show');
        });

        // Apply filters
        $('#applyFilters').on('click', function() {
            const statusFilter = $('#statusFilter').val();
            const dateFilter = $('#dateFilter').val();

            let url = new URL(window.location.href);

            if (statusFilter) {
                url.searchParams.set('status', statusFilter);
            } else {
                url.searchParams.delete('status');
            }

            if (dateFilter) {
                url.searchParams.set('date', dateFilter);
            } else {
                url.searchParams.delete('date');
            }

            window.location.href = url.toString();
        });

        // Clear filters
        $('#clearFilters').on('click', function() {
            $('#statusFilter').val('');
            $('#dateFilter').val('');

            let url = new URL(window.location.href);
            url.searchParams.delete('status');
            url.searchParams.delete('date');

            window.location.href = url.toString();
        });

        // Set filter values from URL parameters
        const url = new URL(window.location.href);
        if (url.searchParams.has('status')) {
            $('#statusFilter').val(url.searchParams.get('status'));
        }
        if (url.searchParams.has('date')) {
            $('#dateFilter').val(url.searchParams.get('date'));
        }
    });

</script>
@endpush
