<x-app-layout>
<x-slot name="header">Dashboard Super Admin</x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="stat-card rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-400">Total Kantin</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $totalCanteens }}</p>
                    <p class="text-xs text-emerald-400 mt-1">{{ $activeCanteens }} aktif</p>
                </div>
                <div class="w-12 h-12 gradient-primary rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
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
                    <p class="text-sm font-medium text-slate-400">Menunggu Persetujuan</p>
                    <p class="text-3xl font-bold text-amber-400 mt-1">{{ $pendingBalanceRequests + $pendingWithdrawals }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $pendingBalanceRequests }} saldo · {{ $pendingWithdrawals }} tarik</p>
                </div>
                <div class="w-12 h-12 gradient-warning rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Canteen List -->
    <div class="rounded-2xl overflow-hidden mb-8" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
        <div class="p-6 flex justify-between items-center" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
            <div>
                <h3 class="text-lg font-semibold text-white">Daftar Kantin</h3>
                <p class="text-sm text-slate-400 mt-1">Ringkasan performa kantin</p>
            </div>
            <a href="{{ route('super-admin.canteens.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-500/10 text-indigo-400 text-sm font-medium rounded-xl hover:bg-indigo-500/20 transition">
                Kelola Kantin
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="p-6">
            @if($canteens->isEmpty())
                <div class="text-center py-8">
                    <p class="text-slate-400">Belum ada kantin terdaftar.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($canteens as $canteen)
                        <div class="rounded-xl p-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(99,102,241,0.08);">
                            <div class="flex items-center gap-3 mb-3">
                                @if($canteen->image)
                                    <img src="{{ asset('storage/' . $canteen->image) }}" class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center text-white font-bold text-sm">{{ strtoupper(substr($canteen->name, 0, 2)) }}</div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-white truncate">{{ $canteen->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $canteen->seller->name ?? '-' }}</p>
                                </div>
                                <span class="w-2 h-2 rounded-full {{ $canteen->is_active ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="rounded-lg p-2 text-center" style="background: rgba(99,102,241,0.08);">
                                    <p class="text-lg font-bold text-white">{{ $canteen->orders_count ?? 0 }}</p>
                                    <p class="text-[10px] text-slate-400">Pesanan Hari Ini</p>
                                </div>
                                <div class="rounded-lg p-2 text-center" style="background: rgba(16,185,129,0.08);">
                                    <p class="text-sm font-bold text-emerald-400">Rp {{ number_format($canteen->balance, 0, ',', '.') }}</p>
                                    <p class="text-[10px] text-slate-400">Saldo Kantin</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Balance Requests -->
        <div class="rounded-2xl overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="p-5 flex justify-between items-center" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                <h3 class="text-sm font-semibold text-white">Permintaan Saldo Terbaru</h3>
                <a href="{{ route('super-admin.balance-requests.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300">Lihat Semua →</a>
            </div>
            <div class="p-5 space-y-3">
                @forelse($recentBalanceRequests as $req)
                    <div class="flex items-center justify-between py-2">
                        <div class="flex items-center gap-3">
                            <img src="{{ $req->user->profile_photo_url }}" class="w-8 h-8 rounded-full">
                            <div>
                                <p class="text-sm text-white font-medium">{{ $req->user->name }}</p>
                                <p class="text-xs text-slate-400">Rp {{ number_format($req->amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full font-medium
                            @if($req->status === 'pending') bg-amber-500/15 text-amber-400
                            @elseif($req->status === 'approved') bg-emerald-500/15 text-emerald-400
                            @else bg-red-500/15 text-red-400
                            @endif">{{ ucfirst($req->status) }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center py-4">Belum ada permintaan.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Withdrawals -->
        <div class="rounded-2xl overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="p-5 flex justify-between items-center" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                <h3 class="text-sm font-semibold text-white">Penarikan Dana Terbaru</h3>
                <a href="{{ route('super-admin.withdrawals.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300">Lihat Semua →</a>
            </div>
            <div class="p-5 space-y-3">
                @forelse($recentWithdrawals as $wd)
                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="text-sm text-white font-medium">{{ $wd->canteen->name }}</p>
                            <p class="text-xs text-slate-400">Rp {{ number_format($wd->amount, 0, ',', '.') }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full font-medium
                            @if($wd->status === 'pending') bg-amber-500/15 text-amber-400
                            @elseif($wd->status === 'approved') bg-emerald-500/15 text-emerald-400
                            @else bg-red-500/15 text-red-400
                            @endif">{{ ucfirst($wd->status) }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center py-4">Belum ada penarikan.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
