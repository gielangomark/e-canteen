<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $canteen = $user->canteen;
        $date = $request->input('date', now()->toDateString());
        $status = $request->input('status');
        $pickupTime = $request->input('pickup_time');

        $query = Order::where('canteen_id', $canteen->id)
            ->whereDate('order_date', $date)
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

        return view('seller.orders.index', compact('orders', 'ordersIstirahat1', 'ordersIstirahat2', 'date', 'status', 'pickupTime'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $canteen = $user->canteen;
        if ($order->canteen_id !== $canteen->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // When order is completed, add earnings to canteen balance
        if ($request->status === 'completed' && $oldStatus !== 'completed') {
            $canteen->update([
                'balance' => $canteen->balance + $order->total_amount,
            ]);
        }

        return redirect()->back()->with('success', "Status pesanan #{$order->id} diperbarui menjadi {$order->status_label}!");
    }
}
