<x-app-layout>
<x-slot name="header"> 
        Dashboard
     </x-slot>

    <!-- Welcome & Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        <div class="stat-card rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="flex items-center gap-4">
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-14 h-14 rounded-full object-cover ring-2 ring-indigo-500/20">
                <div>
                    <p class="text-sm text-slate-400">Selamat Datang</p>
                    <p class="text-xl font-bold text-white">{{ $user->name }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-400">Saldo Anda</p>
                    <p class="text-3xl font-bold text-emerald-400 mt-1">{{ $user->formatted_balance }}</p>
                </div>
                <div class="w-12 h-12 gradient-success rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <a href="{{ route('user.balance.index') }}" class="inline-flex items-center gap-1 text-sm text-indigo-400 font-medium mt-3 hover:text-indigo-300 transition">
                Isi Saldo
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="stat-card rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-400">Pesanan Aktif</p>
                    <p class="text-3xl font-bold text-indigo-400 mt-1">{{ $activeOrders->count() }}</p>
                </div>
                <div class="w-12 h-12 gradient-info rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
            </div>
            <a href="{{ route('user.orders.index') }}" class="inline-flex items-center gap-1 text-sm text-indigo-400 font-medium mt-3 hover:text-indigo-300 transition">
                Lihat Pesanan
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
        <a href="{{ route('user.menu.index') }}" class="group relative overflow-hidden rounded-2xl p-6 text-white shadow-lg transition-all duration-300 hover:-translate-y-1" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); box-shadow: 0 10px 30px rgba(99,102,241,0.25);">
            <div class="relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold">Pesan Sekarang</p>
                        <p class="text-sm text-white/70">Lihat menu dan buat pesanan baru</p>
                    </div>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
        </a>
        <a href="{{ route('user.cart.index') }}" class="group relative overflow-hidden rounded-2xl p-6 text-white shadow-lg transition-all duration-300 hover:-translate-y-1" style="background: linear-gradient(135deg, #0ea5e9 0%, #6366f1 100%); box-shadow: 0 10px 30px rgba(14,165,233,0.25);">
            <div class="relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold">Keranjang</p>
                        <p class="text-sm text-white/70">Lihat dan checkout keranjang Anda</p>
                    </div>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
        </a>
    </div>

    <!-- Active Orders -->
    @if($activeOrders->isNotEmpty())
        <div class="rounded-2xl overflow-hidden mb-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="p-6" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                <h3 class="text-lg font-semibold text-white">Pesanan Aktif</h3>
            </div>
            <div class="p-4 space-y-3">
                @foreach($activeOrders as $order)
                    <a href="{{ route('user.orders.show', $order) }}" class="block p-4 rounded-xl transition-all hover:-translate-y-0.5" style="border: 1px solid rgba(99,102,241,0.1); background: rgba(15,23,42,0.3);" onmouseover="this.style.borderColor='rgba(129,140,248,0.25)'" onmouseout="this.style.borderColor='rgba(99,102,241,0.1)'">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(99,102,241,0.15);">
                                <span class="text-sm font-bold text-indigo-400">#{{ $order->id }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-white">Pesanan #{{ $order->id }}</p>
                                <p class="text-sm text-slate-400">{{ $order->canteen->name ?? '' }} &middot; {{ $order->pickup_time_label }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pl-13">
                            <span class="text-base font-bold text-emerald-400">{{ $order->formatted_total }}</span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $order->status_badge_class }}">
                                {{ $order->status_label }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Recent Orders -->
    @if($recentOrders->isNotEmpty())
        <div class="rounded-2xl overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="p-6" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white">Riwayat Pesanan</h3>
                    <a href="{{ route('user.orders.index') }}" class="inline-flex items-center gap-1 text-sm text-indigo-400 font-medium hover:text-indigo-300 transition">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            <div class="divide-y" style="border-color: rgba(99,102,241,0.08);">
                @foreach($recentOrders as $order)
                    <a href="{{ route('user.orders.show', $order) }}" class="block px-5 py-4 transition" style="border-bottom: 1px solid rgba(99,102,241,0.06);" onmouseover="this.style.background='rgba(99,102,241,0.05)'" onmouseout="this.style.background='transparent'">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-white">#{{ $order->id }}</span>
                                @if($order->canteen)
                                    <span class="text-xs text-indigo-400">{{ $order->canteen->name }}</span>
                                @endif
                                <span class="text-xs text-slate-500">•</span>
                                <span class="text-sm text-slate-400">{{ $order->created_at->format('d/m/Y') }}</span>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $order->status_badge_class }}">
                                {{ $order->status_label }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500">{{ $order->items->count() }} item</span>
                            <span class="text-base font-bold text-emerald-400">{{ $order->formatted_total }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</x-app-layout>
