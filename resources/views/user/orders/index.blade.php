<x-app-layout>
    <x-slot name="header">
        Pesanan Saya
    </x-slot>

    <div class="space-y-4">
        @forelse($orders as $order)
            <a href="{{ route('user.orders.show', $order) }}" class="block rounded-2xl p-5 hover:shadow-lg hover:shadow-indigo-500/10 transition-all duration-300 group" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="font-bold text-white text-lg">#{{ $order->id }}</span>
                            @if($order->canteen)
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-lg bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">{{ $order->canteen->name }}</span>
                            @endif
                            <span class="px-3 py-1 text-xs font-bold rounded-lg {{ $order->status_badge_class }}">
                                {{ $order->status_label }}
                            </span>
                        </div>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-slate-400">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $order->pickup_time_label }}
                            </span>
                            <span class="flex items-center gap-1.5 text-slate-500">
                                {{ $order->items->count() }} item
                            </span>
                        </div>
                        @if($order->items->isNotEmpty())
                            <p class="text-xs text-slate-500 mt-2 truncate">
                                {{ $order->items->pluck('menu.name')->filter()->implode(', ') }}
                            </p>
                        @endif
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-xl font-extrabold text-emerald-400">{{ $order->formatted_total }}</span>
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>
        @empty
            <div class="text-center py-16">
                <svg class="w-20 h-20 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="text-xl font-semibold text-slate-400 mb-2">Belum ada pesanan</p>
                <p class="text-sm text-slate-500 mb-6">Yuk pesan menu favoritmu!</p>
                <a href="{{ route('user.menu.index') }}" class="inline-flex items-center gap-2 px-6 py-3 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Lihat Menu
                </a>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
