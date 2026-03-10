<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBalanceRequestRequest;
use App\Models\BalanceRequest;

class BalanceRequestController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $requests = BalanceRequest::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('user.balance.index', compact('user', 'requests'));
    }

    public function store(StoreBalanceRequestRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Create as pending — super admin must approve
        BalanceRequest::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return redirect()->route('user.balance.index')->with('success', 'Permintaan isi saldo Rp ' . number_format($request->amount, 0, ',', '.') . ' telah dikirim. Menunggu persetujuan admin.');
    }
}
