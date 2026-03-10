<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $canteen = $user->canteen;
        $date = $request->input('date', now()->toDateString());

        $totalRevenue = Order::where('canteen_id', $canteen->id)
            ->whereDate('order_date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->sum('total_amount');

        $totalOrders = Order::where('canteen_id', $canteen->id)
            ->whereDate('order_date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->count();

        $menuSales = OrderItem::whereHas('order', function ($q) use ($date, $canteen) {
            $q->where('canteen_id', $canteen->id)
                ->whereDate('order_date', $date)
                ->whereNotIn('status', ['cancelled']);
        })
            ->select('menu_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('menu_id')
            ->with('menu')
            ->orderByDesc('total_qty')
            ->get();

        return view('seller.reports.index', compact('canteen', 'date', 'totalRevenue', 'totalOrders', 'menuSales'));
    }
}
