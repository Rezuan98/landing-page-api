<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class IndexController extends Controller
{

    public function adminLogin()
    {
        return view('backend.login');
    }


    public function index()
    {
        // Set default values in case orders table doesn't exist yet
        $pendingOrders = 0;
        $completedOrders = 0;
        $totalSales = 0;
        $pendingOrdersChart = "0, 0, 0, 0, 0, 0, 0";
        $completedOrdersChart = "0, 0, 0, 0, 0, 0, 0";
        $salesChart = "0, 0, 0, 0, 0, 0, 0";
        $orderGrowthRate = 0;
        $salesGrowthRate = 0;
        $recentOrders = collect([]);

        // Check if the orders table exists
        try {
            // Get count of pending orders
            $pendingOrders = Order::where('status', 'pending')->count();
            
            // Get count of completed orders
            $completedOrders = Order::where('status', 'completed')->count();
            
            // Calculate total sales amount
            $totalSales = Order::where('status', 'completed')->sum('total');
            
            // Get recent orders for the dashboard table (last 5)
            $recentOrders = Order::orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            // Generate data for sparkline charts (last 7 days) — 3 queries instead of 21
            $sevenDaysAgo = Carbon::now()->subDays(6)->startOfDay();

            $chartRows = Order::select(
                    DB::raw('DATE(created_at) as date'),
                    'status',
                    DB::raw('COUNT(*) as count'),
                    DB::raw('SUM(total) as total_sales')
                )
                ->where('created_at', '>=', $sevenDaysAgo)
                ->whereIn('status', ['pending', 'completed'])
                ->groupBy(DB::raw('DATE(created_at)'), 'status')
                ->get()
                ->groupBy('date');

            $pendingOrdersChartData = [];
            $completedOrdersChartData = [];
            $salesChartData = [];

            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $dayRows = $chartRows->get($date, collect());

                $pending   = $dayRows->firstWhere('status', 'pending');
                $completed = $dayRows->firstWhere('status', 'completed');

                $pendingOrdersChartData[]   = $pending   ? $pending->count       : 0;
                $completedOrdersChartData[] = $completed ? $completed->count     : 0;
                $salesChartData[]           = $completed ? ($completed->total_sales ?: 0) : 0;
            }

            $pendingOrdersChart   = implode(', ', $pendingOrdersChartData);
            $completedOrdersChart = implode(', ', $completedOrdersChartData);
            $salesChart           = implode(', ', $salesChartData);
            
            // Calculate growth rates (compared to previous period)
            // Growth rate for completed orders
            $currentPeriodStart = Carbon::now()->subDays(7);
            $currentPeriodCount = Order::where('status', 'completed')
                ->where('created_at', '>=', $currentPeriodStart)
                ->count();
            
            $previousPeriodStart = Carbon::now()->subDays(14);
            $previousPeriodEnd = Carbon::now()->subDays(7);
            $previousPeriodCount = Order::where('status', 'completed')
                ->where('created_at', '>=', $previousPeriodStart)
                ->where('created_at', '<', $previousPeriodEnd)
                ->count();
            
            if ($previousPeriodCount > 0) {
                $orderGrowthRate = (($currentPeriodCount - $previousPeriodCount) / $previousPeriodCount) * 100;
                $orderGrowthRate = round($orderGrowthRate, 1);
            }
            
            // Growth rate for sales
            $currentPeriodSales = Order::where('status', 'completed')
                ->where('created_at', '>=', $currentPeriodStart)
                ->sum('total');
            
            $previousPeriodSales = Order::where('status', 'completed')
                ->where('created_at', '>=', $previousPeriodStart)
                ->where('created_at', '<', $previousPeriodEnd)
                ->sum('total');
            
            if ($previousPeriodSales > 0) {
                $salesGrowthRate = (($currentPeriodSales - $previousPeriodSales) / $previousPeriodSales) * 100;
                $salesGrowthRate = round($salesGrowthRate, 1);
            }
        } catch (\Exception $e) {
            // If there's an error, we'll just use the default values
        }
        
        return view('backend.index', compact(
            'pendingOrders',
            'completedOrders',
            'totalSales',
            'recentOrders',
            'pendingOrdersChart',
            'completedOrdersChart',
            'salesChart',
            'orderGrowthRate',
            'salesGrowthRate'
        ));
    }
}
