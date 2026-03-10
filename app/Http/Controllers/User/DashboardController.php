<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $activeOrders = Order::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->with(['items.menu', 'canteen'])
            ->latest()
            ->get();

        $recentOrders = Order::where('user_id', $user->id)
            ->with('canteen')
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('user', 'activeOrders', 'recentOrders'));
    }
}
