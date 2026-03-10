<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $canteen = $user->canteen;
        $withdrawals = Withdrawal::where('canteen_id', $canteen->id)
            ->latest()
            ->paginate(15);

        return view('seller.withdrawals.index', compact('canteen', 'withdrawals'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $canteen = $user->canteen;

        $request->validate([
            'amount' => 'required|numeric|min:1000',
        ], [
            'amount.required' => 'Jumlah withdrawal wajib diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah withdrawal minimal Rp 1.000.',
        ]);

        if ($canteen->balance < $request->amount) {
            return redirect()->back()->with('error', 'Saldo kantin tidak mencukupi. Saldo: ' . $canteen->formatted_balance);
        }

        Withdrawal::create([
            'canteen_id' => $canteen->id,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('seller.withdrawals.index')->with('success', 'Permintaan withdrawal Rp ' . number_format($request->amount, 0, ',', '.') . ' berhasil dikirim!');
    }
}
