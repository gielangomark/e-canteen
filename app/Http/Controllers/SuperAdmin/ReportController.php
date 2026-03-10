<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $canteenId = $request->input('canteen_id');

        $query = Order::whereDate('order_date', $date)
            ->whereNotIn('status', ['cancelled']);

        if ($canteenId) {
            $query->where('canteen_id', $canteenId);
        }

        $totalRevenue = (clone $query)->sum('total_amount');
        $totalOrders = (clone $query)->count();

        $menuSalesQuery = OrderItem::whereHas('order', function ($q) use ($date, $canteenId) {
            $q->whereDate('order_date', $date)
                ->whereNotIn('status', ['cancelled']);
            if ($canteenId) {
                $q->where('canteen_id', $canteenId);
            }
        });

        $menuSales = $menuSalesQuery
            ->select('menu_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('menu_id')
            ->with('menu.canteen')
            ->orderByDesc('total_qty')
            ->get();

        // Per-canteen summary
        $canteenSummaries = Order::whereDate('order_date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->select('canteen_id', DB::raw('COUNT(*) as total_orders'), DB::raw('SUM(total_amount) as total_revenue'))
            ->groupBy('canteen_id')
            ->with('canteen')
            ->get();

        $canteens = Canteen::where('is_active', true)->get();

        return view('super-admin.reports.index', compact(
            'date',
            'canteenId',
            'totalRevenue',
            'totalOrders',
            'menuSales',
            'canteenSummaries',
            'canteens'
        ));
    }
}
