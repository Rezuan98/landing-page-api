@extends('backend.dashboard')

@section('KEYTITLE', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
            <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
            <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
        </div>
        <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="printer"></i>
            Print
        </button>
        <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="download-cloud"></i>
            Download Report
        </button>
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <!-- Total Pending Orders Card -->
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Total Pending Orders</h6>
                            <div class="dropdown mb-2">
                                <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('index.order') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View Orders</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">{{ $pendingOrders }}</h3>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-warning">
                                        <span>Requires Attention</span>
                                        <i data-feather="clock" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <div id="pendingOrdersChart" class="mt-md-3 mt-xl-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Completed Orders Card -->
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Total Completed Orders</h6>
                            <div class="dropdown mb-2">
                                <a type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('index.order') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View Orders</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">{{ $completedOrders }}</h3>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <span>+{{ $orderGrowthRate }}%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <div id="completedOrdersChart" class="mt-md-3 mt-xl-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Sales Amount Card -->
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Total Sales Amount</h6>
                            <div class="dropdown mb-2">
                                <a type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View Report</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">${{ number_format($totalSales, 2) }}</h3>
                                <div class="d-flex align-items-baseline">
                                    <p class="text-success">
                                        <span>+{{ $salesGrowthRate }}%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <div id="salesChart" class="mt-md-3 mt-xl-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->

<!-- Recent Orders Section -->
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-4">
                    <h6 class="card-title mb-0">Recent Orders</h6>
                    <a href="{{ route('index.order') }}" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $key => $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>
                                    @if($order->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                    @elseif($order->status == 'processing')
                                    <span class="badge bg-info">Processing</span>
                                    @elseif($order->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                    @elseif($order->status == 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="javascript:;" class="btn btn-outline-secondary btn-sm">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No recent orders found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(function() {
        // Pending Orders Chart
        var pendingOrdersOptions = {
            chart: {
                type: 'line'
                , height: 60
                , sparkline: {
                    enabled: true
                }
            }
            , series: [{
                name: 'Pending Orders'
                , data: [{
                    {
                        $pendingOrdersChart
                    }
                }]
            }]
            , stroke: {
                width: 2
                , curve: 'smooth'
            }
            , markers: {
                size: 0
            }
            , colors: ['#FFC107']
            , tooltip: {
                fixed: {
                    enabled: false
                }
                , x: {
                    show: false
                }
                , y: {
                    title: {
                        formatter: function(seriesName) {
                            return '';
                        }
                    }
                }
                , marker: {
                    show: false
                }
            }
        };
        new ApexCharts(document.querySelector('#pendingOrdersChart'), pendingOrdersOptions).render();

        // Completed Orders Chart
        var completedOrdersOptions = {
            chart: {
                type: 'line'
                , height: 60
                , sparkline: {
                    enabled: true
                }
            }
            , series: [{
                name: 'Completed Orders'
                , data: [{
                    {
                        $completedOrdersChart
                    }
                }]
            }]
            , stroke: {
                width: 2
                , curve: 'smooth'
            }
            , markers: {
                size: 0
            }
            , colors: ['#28a745']
            , tooltip: {
                fixed: {
                    enabled: false
                }
                , x: {
                    show: false
                }
                , y: {
                    title: {
                        formatter: function(seriesName) {
                            return '';
                        }
                    }
                }
                , marker: {
                    show: false
                }
            }
        };
        new ApexCharts(document.querySelector('#completedOrdersChart'), completedOrdersOptions).render();

        // Sales Chart
        var salesChartOptions = {
            chart: {
                type: 'line'
                , height: 60
                , sparkline: {
                    enabled: true
                }
            }
            , series: [{
                name: 'Sales'
                , data: [{
                    {
                        $salesChart
                    }
                }]
            }]
            , stroke: {
                width: 2
                , curve: 'smooth'
            }
            , markers: {
                size: 0
            }
            , colors: ['#4B49AC']
            , tooltip: {
                fixed: {
                    enabled: false
                }
                , x: {
                    show: false
                }
                , y: {
                    title: {
                        formatter: function(seriesName) {
                            return '$';
                        }
                    }
                }
                , marker: {
                    show: false
                }
            }
        };
        new ApexCharts(document.querySelector('#salesChart'), salesChartOptions).render();
    });

</script>
@endpush
