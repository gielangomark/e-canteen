<x-app-layout>
<x-slot name="header">Dashboard Penjual</x-slot>

    @if(!$canteen)
        <div class="rounded-2xl p-16 text-center" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center mx-auto mb-5">
                <span class="text-4xl">🏪</span>
            </div>
            <p class="text-lg font-semibold text-slate-300">Kantin belum disiapkan</p>
            <p class="text-sm text-slate-500 mt-1">Hubungi Super Admin untuk mengaitkan akun Anda dengan kantin.</p>
        </div>
    @else
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="stat-card rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-400">Pesanan Hari Ini</p>
                        <p class="text-3xl font-bold text-white mt-1">{{ $todayOrders }}</p>
                    </div>
                    <div class="w-12 h-12 gradient-info rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                </div>
            </div>

            <div class="stat-card rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-400">Pendapatan Hari Ini</p>
                        <p class="text-3xl font-bold text-emerald-400 mt-1">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 gradient-success rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <div class="stat-card rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-400">Total Menu</p>
                        <p class="text-3xl font-bold text-white mt-1">{{ $menuCount }}</p>
                    </div>
                    <div class="w-12 h-12 gradient-primary rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
            </div>

            <div class="stat-card rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-400">Saldo Kantin</p>
                        <p class="text-3xl font-bold text-amber-400 mt-1">Rp {{ number_format($canteen->balance, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 gradient-warning rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="rounded-2xl overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="p-6 flex justify-between items-center" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                <div>
                    <h3 class="text-lg font-semibold text-white">Pesanan Perlu Diproses</h3>
                    <p class="text-sm text-slate-400 mt-1">{{ $pendingOrders->count() }} pesanan menunggu</p>
                </div>
                <a href="{{ route('seller.orders.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-500/10 text-indigo-400 text-sm font-medium rounded-xl hover:bg-indigo-500/20 transition">
                    Lihat Semua →
                </a>
            </div>
            <div class="p-6">
                @if($pendingOrders->isEmpty())
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        <p class="text-slate-400 font-medium">Semua pesanan sudah diproses!</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($pendingOrders->take(5) as $order)
                            <div class="flex items-center justify-between p-3 rounded-xl" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(99,102,241,0.08);">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center">
                                        <span class="text-xs font-bold text-indigo-400">#{{ $order->id }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-white">{{ $order->user->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $order->formatted_total }} · {{ $order->status_label }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->status_badge_class }}">
                                    {{ $order->status_label }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
</x-app-layout>
