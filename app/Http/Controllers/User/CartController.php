<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;
        $groupedByCanteen = [];

        foreach ($cart as $menuId => $quantity) {
            $menu = Menu::with('canteen')->find($menuId);
            if ($menu) {
                $subtotal = $menu->price * $quantity;
                $item = [
                    'menu' => $menu,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
                $cartItems[] = $item;
                $total += $subtotal;

                $canteenName = $menu->canteen ? $menu->canteen->name : 'Lainnya';
                $canteenId = $menu->canteen_id ?? 0;
                if (!isset($groupedByCanteen[$canteenId])) {
                    $groupedByCanteen[$canteenId] = [
                        'canteen' => $menu->canteen,
                        'items' => [],
                        'subtotal' => 0,
                    ];
                }
                $groupedByCanteen[$canteenId]['items'][] = $item;
                $groupedByCanteen[$canteenId]['subtotal'] += $subtotal;
            }
        }

        return view('user.cart.index', compact('cartItems', 'total', 'groupedByCanteen'));
    }

    public function add(Request $request, Menu $menu)
    {
        if (!$menu->is_available) {
            return redirect()->back()->with('error', 'Menu ini sedang tidak tersedia.');
        }

        $cart = session()->get('cart', []);
        $cart[$menu->id] = ($cart[$menu->id] ?? 0) + 1;
        session()->put('cart', $cart);

        return redirect()->back()->with('success', "{$menu->name} ditambahkan ke keranjang!");
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $cart = session()->get('cart', []);
        $cart[$menu->id] = $request->quantity;
        session()->put('cart', $cart);

        return redirect()->route('user.cart.index')->with('success', 'Jumlah diperbarui!');
    }

    public function remove(Menu $menu)
    {
        $cart = session()->get('cart', []);
        unset($cart[$menu->id]);
        session()->put('cart', $cart);

        return redirect()->route('user.cart.index')->with('success', "{$menu->name} dihapus dari keranjang.");
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('user.cart.index')->with('success', 'Keranjang dikosongkan.');
    }
}
