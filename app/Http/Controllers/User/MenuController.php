<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $canteens = Canteen::where('is_active', true)
            ->withCount(['menus' => function ($q) {
                $q->where('is_available', true);
            }])
            ->get();

        return view('user.menu.canteens', compact('canteens'));
    }

    public function search()
    {
        $query = request('q', '');

        $menus = Menu::where('is_available', true)
            ->whereHas('canteen', fn ($q) => $q->where('is_active', true))
            ->when($query, function ($builder) use ($query) {
                $builder->where('name', 'like', '%' . $query . '%');
            })
            ->with('canteen')
            ->get();

        $cart = session()->get('cart', []);

        return view('user.menu.search', compact('menus', 'query', 'cart'));
    }

    public function canteen(Canteen $canteen)
    {
        if (!$canteen->is_active) {
            return redirect()->route('user.menu.index')->with('error', 'Kantin tidak aktif.');
        }

        $menus = $canteen->menus()->where('is_available', true)->get();

        $makanan = $menus->where('category', 'makanan');
        $minuman = $menus->where('category', 'minuman');
        $snack = $menus->where('category', 'snack');

        $cart = session()->get('cart', []);

        return view('user.menu.index', compact('canteen', 'makanan', 'minuman', 'snack', 'cart'));
    }
}
