<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('canteen.seller')
            ->latest()
            ->paginate(20);

        $pendingCount = Withdrawal::where('status', 'pending')->count();

        return view('super-admin.withdrawals.index', compact('withdrawals', 'pendingCount'));
    }

    public function approve(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses sebelumnya.');
        }

        $canteen = $withdrawal->canteen;

        if ($canteen->balance < $withdrawal->amount) {
            return redirect()->back()->with('error', 'Saldo kantin tidak mencukupi untuk withdrawal ini.');
        }

        $withdrawal->update(['status' => 'approved']);

        // Deduct canteen balance
        $canteen->update([
            'balance' => $canteen->balance - $withdrawal->amount,
        ]);

        return redirect()->back()->with('success', 'Withdrawal Rp ' . number_format($withdrawal->amount, 0, ',', '.') . ' dari ' . $canteen->name . ' disetujui!');
    }

    public function reject(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses sebelumnya.');
        }

        $withdrawal->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Permintaan withdrawal ditolak.');
    }
}
