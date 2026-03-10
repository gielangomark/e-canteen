<x-app-layout>
<x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('user.orders.index') }}" class="p-2 rounded-lg text-slate-400 hover:bg-white/5 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <span>Detail Pesanan #{{ $order->id }}</span>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Order Status -->
        <div class="rounded-2xl p-6 mb-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-white">Status Pesanan</h3>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $order->status_badge_class }} mt-2">
                        {{ $order->status_label }}
                    </span>
                </div>
                <div class="text-right">
                    @if($order->canteen)
                        <p class="text-sm text-slate-400">Kantin</p>
                        <p class="font-semibold text-white">{{ $order->canteen->name }}</p>
                        <p class="text-sm text-slate-400 mt-2">Waktu Pengambilan</p>
                    @else
                        <p class="text-sm text-slate-400">Waktu Pengambilan</p>
                    @endif
                    <p class="font-semibold text-white">{{ $order->pickup_time_label }}</p>
                </div>
            </div>

            @if($order->notes)
                <div class="mt-4 p-4 bg-white/5 rounded-xl">
                    <span class="text-sm font-medium text-slate-400">Catatan:</span>
                    <p class="text-sm text-white mt-1">{{ $order->notes }}</p>
                </div>
            @endif

            <!-- Status Timeline -->
            <div class="mt-6 flex items-center gap-2">
                <?php
                    $statuses = ['pending' => 'Menunggu', 'preparing' => 'Disiapkan', 'ready' => 'Siap', 'completed' => 'Selesai'];
                    $statusOrder = array_keys($statuses);
                    $currentIndex = array_search($order->status, $statusOrder);
                    if ($order->status === 'cancelled') $currentIndex = -1;
                ?>
                @foreach($statuses as $key => $label)
                    @php $index = array_search($key, $statusOrder); @endphp
                    <div class="flex items-center gap-2 {{ $loop->last ? '' : 'flex-1' }}">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-all
                            {{ $index <= $currentIndex ? 'gradient-success text-white shadow-lg shadow-emerald-500/30' : 'bg-white/10 text-slate-500' }}
                        ">
                            @if($index < $currentIndex)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                        <span class="text-xs font-medium text-slate-400 hidden sm:inline">{{ $label }}</span>
                        @if(!$loop->last)
                            <div class="flex-1 h-0.5 rounded {{ $index < $currentIndex ? 'bg-emerald-400' : 'bg-white/10' }}"></div>
                        @endif
                    </div>
                @endforeach
            </div>
            @if($order->status === 'cancelled')
                <div class="mt-3 flex items-center gap-2 text-red-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span class="text-sm font-semibold">Pesanan ini telah dibatalkan.</span>
                </div>
            @endif
        </div>

        <!-- Order Items -->
        <div class="rounded-2xl overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="p-6" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                <h3 class="text-lg font-semibold text-white">Item Pesanan</h3>
            </div>
            <div class="p-6 space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            @if($item->menu && $item->menu->image)
                                <img src="{{ asset('storage/' . $item->menu->image) }}" alt="{{ $item->menu->name }}" class="w-14 h-14 object-cover rounded-xl">
                            @else
                                <div class="w-14 h-14 bg-white/5 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-semibold text-white">{{ $item->menu->name ?? 'Menu dihapus' }}</h4>
                                <p class="text-sm text-slate-400">Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <span class="font-semibold text-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

            <div class="px-6 py-4 bg-white/5" style="border-top: 1px solid rgba(99,102,241,0.1);">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-white">Total</span>
                    <span class="text-2xl font-extrabold text-emerald-400">{{ $order->formatted_total }}</span>
                </div>
                <p class="text-sm text-slate-400 mt-2">Dipesan pada: {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
