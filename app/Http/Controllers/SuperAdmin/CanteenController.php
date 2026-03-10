<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CanteenController extends Controller
{
    public function index()
    {
        $canteens = Canteen::with('seller')->withCount('menus')->latest()->get();
        return view('super-admin.canteens.index', compact('canteens'));
    }

    public function create()
    {
        return view('super-admin.canteens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'canteen_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'seller_name' => 'required|string|max:255',
            'seller_email' => 'required|email|unique:users,email',
            'seller_password' => 'required|string|min:6',
        ]);

        // Create seller user
        $seller = User::create([
            'name' => $request->seller_name,
            'email' => $request->seller_email,
            'password' => Hash::make($request->seller_password),
            'role' => 'seller',
            'balance' => 0,
            'email_verified_at' => now(),
        ]);

        $data = [
            'seller_id' => $seller->id,
            'name' => $request->canteen_name,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('canteen-images', 'public');
        }

        Canteen::create($data);

        return redirect()->route('super-admin.canteens.index')->with('success', 'Kantin dan akun penjual berhasil dibuat!');
    }

    public function edit(Canteen $canteen)
    {
        $canteen->load('seller');
        return view('super-admin.canteens.edit', compact('canteen'));
    }

    public function update(Request $request, Canteen $canteen)
    {
        $request->validate([
            'canteen_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $request->canteen_name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            if ($canteen->image) {
                Storage::disk('public')->delete($canteen->image);
            }
            $data['image'] = $request->file('image')->store('canteen-images', 'public');
        }

        $canteen->update($data);

        return redirect()->route('super-admin.canteens.index')->with('success', 'Kantin berhasil diperbarui!');
    }

    public function destroy(Canteen $canteen)
    {
        if ($canteen->image) {
            Storage::disk('public')->delete($canteen->image);
        }

        // Also delete the seller user
        if ($canteen->seller) {
            $canteen->seller->delete();
        }

        $canteen->delete();

        return redirect()->route('super-admin.canteens.index')->with('success', 'Kantin berhasil dihapus!');
    }
}
