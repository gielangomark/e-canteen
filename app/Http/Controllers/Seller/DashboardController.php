<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        $canteen = $user->canteen;

        if (!$canteen) {
            return view('seller.no-canteen');
        }

        $today = now()->toDateString();

        $todayOrders = Order::where('canteen_id', $canteen->id)
            ->whereDate('order_date', $today)
            ->count();

        $todayRevenue = Order::where('canteen_id', $canteen->id)
            ->whereDate('order_date', $today)
            ->whereNotIn('status', ['cancelled'])
            ->sum('total_amount');

        $menuCount = $canteen->menus()->count();

        $pendingOrders = Order::where('canteen_id', $canteen->id)
            ->whereDate('order_date', $today)
            ->whereIn('status', ['pending', 'preparing'])
            ->with(['user', 'items.menu'])
            ->latest()
            ->take(5)
            ->get();

        return view('seller.dashboard', compact(
            'canteen',
            'todayOrders',
            'todayRevenue',
            'menuCount',
            'pendingOrders'
        ));
    }
}
