<x-app-layout>
<x-slot name="header">Permintaan Isi Saldo</x-slot>

    @if($pendingCount > 0)
        <div class="mb-6 rounded-xl p-4 flex items-center gap-3" style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2);">
            <svg class="w-5 h-5 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-sm text-amber-300 font-medium">{{ $pendingCount }} permintaan menunggu persetujuan</span>
        </div>
    @endif

    <div class="rounded-2xl overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                        <th class="px-5 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Siswa</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Jumlah</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($requests as $req)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $req->user->profile_photo_url }}" class="w-8 h-8 rounded-full">
                                    <div>
                                        <p class="text-sm font-medium text-white">{{ $req->user->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $req->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm font-semibold text-emerald-400">Rp {{ number_format($req->amount, 0, ',', '.') }}</td>
                            <td class="px-5 py-4 text-sm text-slate-400">{{ $req->created_at->format('d M Y H:i') }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                    @if($req->status === 'pending') bg-amber-500/15 text-amber-400
                                    @elseif($req->status === 'approved') bg-emerald-500/15 text-emerald-400
                                    @else bg-red-500/15 text-red-400
                                    @endif">{{ ucfirst($req->status) }}</span>
                            </td>
                            <td class="px-5 py-4">
                                @if($req->status === 'pending')
                                    <div class="flex gap-2">
                                        <form action="{{ route('super-admin.balance-requests.approve', $req) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="px-3 py-1.5 bg-emerald-500/10 text-emerald-400 text-xs font-semibold rounded-lg hover:bg-emerald-500/20 transition">Setujui</button>
                                        </form>
                                        <form action="{{ route('super-admin.balance-requests.reject', $req) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="px-3 py-1.5 bg-red-500/10 text-red-400 text-xs font-semibold rounded-lg hover:bg-red-500/20 transition">Tolak</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-500">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-500">Belum ada permintaan isi saldo.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
            <div class="px-5 py-4" style="border-top: 1px solid rgba(99,102,241,0.1);">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
