<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BalanceRequest;
use App\Models\User;

class BalanceRequestController extends Controller
{
    public function index()
    {
        $pendingRequests = BalanceRequest::where('status', 'pending')
            ->with('user')
            ->latest()
            ->get();

        $recentRequests = BalanceRequest::whereIn('status', ['approved', 'rejected'])
            ->with('user')
            ->latest()
            ->take(20)
            ->get();

        return view('admin.balance-requests.index', compact('pendingRequests', 'recentRequests'));
    }

    public function approve(BalanceRequest $balanceRequest)
    {
        $balanceRequest->update(['status' => 'approved']);

        // Tambah saldo user
        $user = $balanceRequest->user;
        $user->update([
            'balance' => $user->balance + $balanceRequest->amount,
        ]);

        return redirect()->back()->with('success', "Permintaan saldo {$balanceRequest->formatted_amount} untuk {$user->name} disetujui!");
    }

    public function reject(BalanceRequest $balanceRequest)
    {
        $balanceRequest->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Permintaan saldo ditolak.');
    }
}
