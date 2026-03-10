<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BalanceRequest;

class BalanceRequestController extends Controller
{
    public function index()
    {
        $requests = BalanceRequest::with('user')
            ->latest()
            ->paginate(20);

        $pendingCount = BalanceRequest::where('status', 'pending')->count();

        return view('super-admin.balance-requests.index', compact('requests', 'pendingCount'));
    }

    public function approve(BalanceRequest $balanceRequest)
    {
        if ($balanceRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses sebelumnya.');
        }

        $balanceRequest->update(['status' => 'approved']);

        // Add balance to user
        $balanceRequest->user->update([
            'balance' => $balanceRequest->user->balance + $balanceRequest->amount,
        ]);

        return redirect()->back()->with('success', 'Permintaan saldo Rp ' . number_format($balanceRequest->amount, 0, ',', '.') . ' untuk ' . $balanceRequest->user->name . ' disetujui!');
    }

    public function reject(BalanceRequest $balanceRequest)
    {
        if ($balanceRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses sebelumnya.');
        }

        $balanceRequest->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Permintaan saldo ditolak.');
    }
}
