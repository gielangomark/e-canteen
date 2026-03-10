<x-app-layout>
<x-slot name="header">Antrean Pesanan</x-slot>

    <!-- Filters -->
    <div class="rounded-2xl p-5 mb-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
        <form method="GET" action="{{ route('seller.orders.index') }}" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Tanggal</label>
                <input type="date" name="date" value="{{ $date }}" class="rounded-xl shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Status</label>
                <select name="status" class="rounded-xl shadow-sm text-sm py-2.5 px-4 focus:border-indigo-500 focus:ring-indigo-500" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="preparing" {{ $status === 'preparing' ? 'selected' : '' }}>Sedang Disiapkan</option>
                    <option value="ready" {{ $status === 'ready' ? 'selected' : '' }}>Siap Diambil</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 gradient-primary text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all">Filter</button>
        </form>
    </div>

    <!-- Tabs -->
    <div x-data="{ tab: 'istirahat_1' }">
        <div class="flex gap-3 mb-6">
            <button @click="tab = 'istirahat_1'" :class="{ 'gradient-primary text-white shadow-lg shadow-indigo-500/25': tab === 'istirahat_1', 'text-slate-300': tab !== 'istirahat_1' }" :style="tab !== 'istirahat_1' ? 'background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);' : ''" class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all">
                🕐 Istirahat 1 ({{ $ordersIstirahat1->count() }})
            </button>
            <button @click="tab = 'istirahat_2'" :class="{ 'gradient-primary text-white shadow-lg shadow-indigo-500/25': tab === 'istirahat_2', 'text-slate-300': tab !== 'istirahat_2' }" :style="tab !== 'istirahat_2' ? 'background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);' : ''" class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all">
                🕑 Istirahat 2 ({{ $ordersIstirahat2->count() }})
            </button>
        </div>

        <div x-show="tab === 'istirahat_1'" x-transition>
            @include('seller.orders._order-list', ['orderList' => $ordersIstirahat1])
        </div>
        <div x-show="tab === 'istirahat_2'" x-transition>
            @include('seller.orders._order-list', ['orderList' => $ordersIstirahat2])
        </div>
    </div>
</x-app-layout>
