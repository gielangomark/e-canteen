<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $authUser */
        $authUser = auth()->user();
        $orders = Order::where('user_id', $authUser->id)
            ->with(['items.menu', 'canteen'])
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function store(StoreOrderRequest $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('user.cart.index')->with('error', 'Keranjang kosong!');
        }

        // Group cart items by canteen
        $groupedItems = [];
        $grandTotal = 0;

        foreach ($cart as $menuId => $quantity) {
            $menu = Menu::with('canteen')->find($menuId);
            if (!$menu || !$menu->is_available) {
                return redirect()->route('user.cart.index')->with('error', "Menu \"{$menu?->name}\" sudah tidak tersedia.");
            }

            $subtotal = $menu->price * $quantity;
            $grandTotal += $subtotal;

            $canteenId = $menu->canteen_id;
            if (!isset($groupedItems[$canteenId])) {
                $groupedItems[$canteenId] = ['total' => 0, 'items' => []];
            }
            $groupedItems[$canteenId]['total'] += $subtotal;
            $groupedItems[$canteenId]['items'][] = [
                'menu_id' => $menu->id,
                'quantity' => $quantity,
                'price' => $menu->price,
                'subtotal' => $subtotal,
            ];
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();

        if (!$user->hasSufficientBalance($grandTotal)) {
            return redirect()->route('user.cart.index')->with('error', 'Saldo tidak mencukupi! Saldo: Rp ' . number_format($user->balance, 0, ',', '.') . ', Total: Rp ' . number_format($grandTotal, 0, ',', '.'));
        }

        // Create one order per canteen
        DB::transaction(function () use ($user, $grandTotal, $request, $groupedItems) {
            foreach ($groupedItems as $canteenId => $group) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'canteen_id' => $canteenId,
                    'total_amount' => $group['total'],
                    'status' => 'pending',
                    'pickup_time' => $request->pickup_time,
                    'notes' => $request->notes,
                    'order_date' => now()->toDateString(),
                ]);

                foreach ($group['items'] as $item) {
                    $order->items()->create($item);
                }
            }

            $user->update([
                'balance' => $user->balance - $grandTotal,
            ]);
        });

        session()->forget('cart');

        $orderCount = count($groupedItems);
        $msg = $orderCount > 1
            ? "Pesanan berhasil dibuat ke {$orderCount} kantin! Saldo terpotong Rp " . number_format($grandTotal, 0, ',', '.')
            : 'Pesanan berhasil dibuat! Saldo terpotong Rp ' . number_format($grandTotal, 0, ',', '.');

        return redirect()->route('user.orders.index')->with('success', $msg);
    }

    public function show(Order $order)
    {
        /** @var \App\Models\User $authUser */
        $authUser = auth()->user();
        if ($order->user_id !== $authUser->id) {
            abort(403);
        }

        $order->load(['items.menu', 'canteen']);

        return view('user.orders.show', compact('order'));
    }
}
