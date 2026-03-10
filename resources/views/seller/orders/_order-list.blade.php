@if($orderList->isEmpty())
    <div class="rounded-2xl p-12 text-center" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
        <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        <p class="text-slate-400 font-medium">Tidak ada pesanan</p>
    </div>
@else
    <div class="space-y-4">
        @foreach($orderList as $order)
            <div class="rounded-2xl p-6 hover:shadow-lg transition-all duration-300" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center">
                                <span class="text-xs font-bold text-indigo-400">#{{ $order->id }}</span>
                            </div>
                            <div>
                                <h4 class="text-base font-semibold text-white">Pesanan #{{ $order->id }}</h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $order->status_badge_class }}">
                                    {{ $order->status_label }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span class="text-sm text-slate-400">{{ $order->user->name }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-sm font-semibold text-emerald-400">{{ $order->formatted_total }}</span>
                            </div>
                        </div>

                        @if($order->notes)
                            <div class="mb-3 p-3 bg-amber-500/10 rounded-xl" style="border: 1px solid rgba(245,158,11,0.2);">
                                <span class="text-xs font-semibold text-amber-400">Catatan:</span>
                                <p class="text-sm text-amber-300 mt-0.5">{{ $order->notes }}</p>
                            </div>
                        @endif

                        <div class="mt-3">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Item Pesanan</p>
                            <div class="space-y-1">
                                @foreach($order->items as $item)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-slate-300">{{ $item->menu->name ?? 'Menu dihapus' }} <span class="text-slate-500">x{{ $item->quantity }}</span></span>
                                        <span class="text-slate-400">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Status Actions -->
                    <div class="flex flex-col gap-2 min-w-[160px]">
                        @if($order->status === 'pending')
                            <form action="{{ route('seller.orders.updateStatus', $order) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="preparing">
                                <button type="submit" class="w-full px-4 py-2.5 gradient-primary text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all">Proses Pesanan</button>
                            </form>
                            <form action="{{ route('seller.orders.updateStatus', $order) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="w-full px-4 py-2.5 bg-red-500/10 text-red-400 text-sm font-semibold rounded-xl hover:bg-red-500/20 transition-all" style="border: 1px solid rgba(239,68,68,0.2);" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">Batalkan</button>
                            </form>
                        @elseif($order->status === 'preparing')
                            <form action="{{ route('seller.orders.updateStatus', $order) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="ready">
                                <button type="submit" class="w-full px-4 py-2.5 gradient-success text-white text-sm font-semibold rounded-xl shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 transition-all">Siap Diambil</button>
                            </form>
                        @elseif($order->status === 'ready')
                            <form action="{{ route('seller.orders.updateStatus', $order) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="w-full px-4 py-2.5 bg-slate-600 text-white text-sm font-semibold rounded-xl shadow-lg hover:bg-slate-500 transition-all">Selesai</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
