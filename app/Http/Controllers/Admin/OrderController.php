<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        $status = $request->get('status');
        $pickupTime = $request->get('pickup_time');

        $query = Order::whereDate('order_date', $date)
            ->with(['user', 'items.menu'])
            ->latest();

        if ($status) {
            $query->where('status', $status);
        }

        if ($pickupTime) {
            $query->where('pickup_time', $pickupTime);
        }

        $orders = $query->get();

        $ordersIstirahat1 = $orders->where('pickup_time', 'istirahat_1');
        $ordersIstirahat2 = $orders->where('pickup_time', 'istirahat_2');

        return view('admin.orders.index', compact('orders', 'ordersIstirahat1', 'ordersIstirahat2', 'date', 'status', 'pickupTime'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', "Status pesanan #{$order->id} diperbarui menjadi {$order->status_label}!");
    }
}
