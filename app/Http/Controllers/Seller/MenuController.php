<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    private function getCanteen()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        return $user->canteen;
    }

    public function index()
    {
        $canteen = $this->getCanteen();
        $menus = $canteen->menus()->latest()->get();
        return view('seller.menus.index', compact('menus', 'canteen'));
    }

    public function create()
    {
        return view('seller.menus.create');
    }

    public function store(StoreMenuRequest $request)
    {
        $canteen = $this->getCanteen();
        $data = $request->validated();
        $data['canteen_id'] = $canteen->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menu-images', 'public');
        }

        $data['is_available'] = $request->has('is_available');

        Menu::create($data);

        return redirect()->route('seller.menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        $canteen = $this->getCanteen();
        if ($menu->canteen_id !== $canteen->id) {
            abort(403);
        }

        return view('seller.menus.edit', compact('menu'));
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $canteen = $this->getCanteen();
        if ($menu->canteen_id !== $canteen->id) {
            abort(403);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $data['image'] = $request->file('image')->store('menu-images', 'public');
        }

        $data['is_available'] = $request->has('is_available');

        $menu->update($data);

        return redirect()->route('seller.menus.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        $canteen = $this->getCanteen();
        if ($menu->canteen_id !== $canteen->id) {
            abort(403);
        }

        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('seller.menus.index')->with('success', 'Menu berhasil dihapus!');
    }

    public function toggleAvailability(Menu $menu)
    {
        $canteen = $this->getCanteen();
        if ($menu->canteen_id !== $canteen->id) {
            abort(403);
        }

        $menu->update(['is_available' => !$menu->is_available]);

        $status = $menu->is_available ? 'tersedia' : 'habis';
        return redirect()->route('seller.menus.index')->with('success', "Menu ditandai sebagai {$status}!");
    }
}
