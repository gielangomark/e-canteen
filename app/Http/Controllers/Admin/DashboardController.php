<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $todayOrders = Order::whereDate('order_date', $today)->count();
        $todayRevenue = Order::whereDate('order_date', $today)
            ->whereNotIn('status', ['cancelled'])
            ->sum('total_amount');
        $menuCount = Menu::count();
        $availableMenus = Menu::where('is_available', true)->count();

        $pendingOrders = Order::whereDate('order_date', $today)
            ->whereIn('status', ['pending', 'preparing'])
            ->with(['user', 'items.menu'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'todayOrders',
            'todayRevenue',
            'menuCount',
            'availableMenus',
            'pendingOrders'
        ));
    }
}
