<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BalanceRequest;
use App\Models\Canteen;
use App\Models\Order;
use App\Models\Withdrawal;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCanteens = Canteen::count();
        $activeCanteens = Canteen::where('is_active', true)->count();

        $today = now()->toDateString();
        $todayRevenue = Order::whereDate('order_date', $today)
            ->whereNotIn('status', ['cancelled'])
            ->sum('total_amount');
        $todayOrders = Order::whereDate('order_date', $today)->count();

        $pendingBalanceRequests = BalanceRequest::where('status', 'pending')->count();
        $pendingWithdrawals = Withdrawal::where('status', 'pending')->count();

        $recentBalanceRequests = BalanceRequest::where('status', 'pending')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentWithdrawals = Withdrawal::where('status', 'pending')
            ->with('canteen.seller')
            ->latest()
            ->take(5)
            ->get();

        $canteens = Canteen::with('seller')
            ->withCount(['orders' => function ($q) use ($today) {
                $q->whereDate('order_date', $today);
            }])
            ->get();

        return view('super-admin.dashboard', compact(
            'totalCanteens',
            'activeCanteens',
            'todayRevenue',
            'todayOrders',
            'pendingBalanceRequests',
            'pendingWithdrawals',
            'recentBalanceRequests',
            'recentWithdrawals',
            'canteens'
        ));
    }
}
