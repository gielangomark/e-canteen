<x-app-layout>
<x-slot name="header">Laporan Penjualan</x-slot>

    <!-- Filters -->
    <div class="rounded-2xl p-5 mb-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[140px]">
                <label class="block text-xs font-semibold text-slate-400 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="w-full rounded-xl text-sm py-2.5" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
            </div>
            <div class="flex-1 min-w-[140px]">
                <label class="block text-xs font-semibold text-slate-400 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="w-full rounded-xl text-sm py-2.5" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
            </div>
            <div class="flex-1 min-w-[140px]">
                <label class="block text-xs font-semibold text-slate-400 mb-1">Kantin</label>
                <select name="canteen_id" class="w-full rounded-xl text-sm py-2.5 px-4" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                    <option value="">Semua Kantin</option>
                    @foreach($canteens as $c)
                        <option value="{{ $c->id }}" {{ request('canteen_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 gradient-primary text-white font-semibold rounded-xl text-sm shadow-lg shadow-indigo-500/25">Filter</button>
        </form>
    </div>

    <!-- Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
        <div class="stat-card rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <p class="text-sm text-slate-400">Total Pendapatan</p>
            <p class="text-3xl font-bold text-emerald-400 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="stat-card rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <p class="text-sm text-slate-400">Total Pesanan</p>
            <p class="text-3xl font-bold text-white mt-1">{{ $totalOrders }}</p>
        </div>
    </div>

    <!-- Per-Canteen Summary -->
    @if($canteenSummaries->count() > 0)
        <div class="rounded-2xl overflow-hidden mb-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="p-5" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                <h3 class="text-sm font-semibold text-white">Ringkasan Per Kantin</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-400 uppercase">Kantin</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-400 uppercase">Pesanan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-400 uppercase">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($canteenSummaries as $summary)
                            <tr class="hover:bg-white/5">
                                <td class="px-5 py-3 text-sm text-white">{{ $summary->canteen_name }}</td>
                                <td class="px-5 py-3 text-sm text-slate-300">{{ $summary->order_count }}</td>
                                <td class="px-5 py-3 text-sm font-semibold text-emerald-400">Rp {{ number_format($summary->revenue, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Menu Sales -->
    <div class="rounded-2xl overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
        <div class="p-5" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
            <h3 class="text-sm font-semibold text-white">Detail Penjualan Menu</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-400 uppercase">Menu</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-400 uppercase">Kantin</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-400 uppercase">Terjual</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-400 uppercase">Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($menuSales as $sale)
                        <tr class="hover:bg-white/5">
                            <td class="px-5 py-3 text-sm text-white">{{ $sale->menu_name }}</td>
                            <td class="px-5 py-3 text-sm text-slate-400">{{ $sale->canteen_name ?? '-' }}</td>
                            <td class="px-5 py-3 text-sm text-slate-300">{{ $sale->total_qty }}</td>
                            <td class="px-5 py-3 text-sm font-semibold text-emerald-400">Rp {{ number_format($sale->total_revenue, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-slate-500">Belum ada data penjualan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
