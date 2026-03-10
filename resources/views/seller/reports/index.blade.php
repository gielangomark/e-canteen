<x-app-layout>
<x-slot name="header">Laporan Penjualan</x-slot>

    <!-- Date Filter -->
    <div class="rounded-2xl p-5 mb-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
        <form method="GET" action="{{ route('seller.reports.index') }}" class="flex items-end gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Tanggal</label>
                <input type="date" name="date" value="{{ $date }}" class="rounded-xl shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
            </div>
            <button type="submit" class="px-5 py-2.5 gradient-primary text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all">Lihat Laporan</button>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="stat-card rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 gradient-success rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/25">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-400">Total Pendapatan</p>
                    <p class="text-3xl font-extrabold text-emerald-400 mt-0.5">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 gradient-primary rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/25">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-400">Total Pesanan</p>
                    <p class="text-3xl font-extrabold text-indigo-400 mt-0.5">{{ $totalOrders }}</p>
                    <p class="text-xs text-slate-500 mt-1">Tidak termasuk yang dibatalkan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Sales Detail -->
    <div class="rounded-2xl overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
        <div class="p-6" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
            <h3 class="text-lg font-semibold text-white">Detail Penjualan Per Menu</h3>
        </div>
        <div class="p-6">
            @if($menuSales->isEmpty())
                <div class="text-center py-8">
                    <p class="text-slate-400 font-medium">Belum ada penjualan pada tanggal ini</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-400 uppercase">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-400 uppercase">Nama Menu</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-400 uppercase">Kategori</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-slate-400 uppercase">Terjual</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-slate-400 uppercase">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($menuSales as $i => $sale)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="px-4 py-3.5 text-sm text-slate-400">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3.5 text-sm font-semibold text-white">{{ $sale->menu->name ?? 'Menu dihapus' }}</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                            {{ ($sale->menu->category ?? '') === 'makanan' ? 'bg-orange-500/15 text-orange-400' : '' }}
                                            {{ ($sale->menu->category ?? '') === 'minuman' ? 'bg-blue-500/15 text-blue-400' : '' }}
                                            {{ ($sale->menu->category ?? '') === 'snack' ? 'bg-purple-500/15 text-purple-400' : '' }}
                                        ">{{ ucfirst($sale->menu->category ?? '-') }}</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-sm text-white text-right font-medium">{{ $sale->total_qty }} porsi</td>
                                    <td class="px-4 py-3.5 text-sm text-emerald-400 font-semibold text-right">Rp {{ number_format($sale->total_revenue, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-white/5" style="border-top: 2px solid rgba(99,102,241,0.2);">
                                <td colspan="3" class="px-4 py-4 text-sm font-bold text-white">TOTAL</td>
                                <td class="px-4 py-4 text-sm font-bold text-white text-right">{{ $menuSales->sum('total_qty') }} porsi</td>
                                <td class="px-4 py-4 text-sm font-bold text-emerald-400 text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
