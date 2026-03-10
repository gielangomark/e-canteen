<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', now()->toDateString());

        $totalRevenue = Order::whereDate('order_date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->sum('total_amount');

        $totalOrders = Order::whereDate('order_date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->count();

        $menuSales = OrderItem::whereHas('order', function ($query) use ($date) {
            $query->whereDate('order_date', $date)
                ->whereNotIn('status', ['cancelled']);
        })
            ->select('menu_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('menu_id')
            ->with('menu')
            ->orderByDesc('total_qty')
            ->get();

        return view('admin.reports.index', compact('date', 'totalRevenue', 'totalOrders', 'menuSales'));
    }
}
