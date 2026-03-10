<x-app-layout>
<x-slot name="header">Penarikan Dana</x-slot>

    @if($canteen)
        <!-- Balance Info + Request Form -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="stat-card rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                <p class="text-sm text-slate-400 mb-1">Saldo Kantin</p>
                <p class="text-3xl font-bold text-emerald-400">Rp {{ number_format($canteen->balance, 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-2">{{ $canteen->name }}</p>
            </div>

            <div class="rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                <h3 class="text-sm font-semibold text-white mb-4">Ajukan Penarikan</h3>
                <form action="{{ route('seller.withdrawals.store') }}" method="POST">
                    @csrf
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Jumlah (Rp)</label>
                            <input type="number" name="amount" min="1000" max="{{ $canteen->balance }}" step="1000" required placeholder="Min. Rp 1.000"
                                class="w-full rounded-xl text-sm py-2.5" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                            <x-input-error :messages="$errors->get('amount')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Catatan (Opsional)</label>
                            <input type="text" name="notes" placeholder="No. rekening, dll." class="w-full rounded-xl text-sm py-2.5" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                        </div>
                        <button type="submit" class="w-full px-5 py-2.5 gradient-primary text-white font-semibold rounded-xl text-sm shadow-lg shadow-indigo-500/25">Ajukan Penarikan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Withdrawal History -->
    <div class="rounded-2xl overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
        <div class="p-5" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
            <h3 class="text-sm font-semibold text-white">Riwayat Penarikan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-400 uppercase">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-400 uppercase">Jumlah</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-400 uppercase">Catatan</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-400 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($withdrawals as $wd)
                        <tr class="hover:bg-white/5">
                            <td class="px-5 py-3 text-sm text-slate-400">{{ $wd->created_at->format('d M Y H:i') }}</td>
                            <td class="px-5 py-3 text-sm font-semibold text-amber-400">Rp {{ number_format($wd->amount, 0, ',', '.') }}</td>
                            <td class="px-5 py-3 text-sm text-slate-400">{{ $wd->notes ?: '-' }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                    @if($wd->status === 'pending') bg-amber-500/15 text-amber-400
                                    @elseif($wd->status === 'approved') bg-emerald-500/15 text-emerald-400
                                    @else bg-red-500/15 text-red-400
                                    @endif">{{ ucfirst($wd->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-slate-500">Belum ada penarikan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($withdrawals->hasPages())
            <div class="px-5 py-4" style="border-top: 1px solid rgba(99,102,241,0.1);">
                {{ $withdrawals->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
