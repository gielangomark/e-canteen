<x-app-layout>
    <x-slot name="header">
        Keranjang Belanja
    </x-slot>

    @if(empty($cartItems))
        <div class="text-center py-16">
            <svg class="w-20 h-20 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
            <p class="text-xl font-semibold text-slate-400 mb-2">Keranjang kosong</p>
            <p class="text-sm text-slate-500 mb-6">Tambahkan menu favorit kamu!</p>
            <a href="{{ route('user.menu.index') }}" class="inline-flex items-center gap-2 px-6 py-3 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Lihat Menu
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Cart Items Grouped by Canteen -->
            <div class="lg:col-span-2 space-y-6">
                @foreach ($groupedByCanteen as $canteenId => $group)
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-7 h-7 gradient-primary rounded-lg flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($group['canteen']->name ?? '?', 0, 1)) }}
                            </div>
                            <h3 class="text-sm font-semibold text-white">{{ $group['canteen']->name ?? 'Kantin' }}</h3>
                            <span class="text-xs text-slate-500 ml-auto">Subtotal: Rp {{ number_format($group['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        <div class="space-y-3">
                            @foreach ($group['items'] as $item)
                    <div class="rounded-2xl p-5 hover:shadow-lg transition-all duration-300" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                        <div class="flex items-center gap-4">
                            @if($item['menu']->image)
                                <img src="{{ asset('storage/' . $item['menu']->image) }}" alt="{{ $item['menu']->name }}" class="w-20 h-20 object-cover rounded-xl">
                            @else
                                <div class="w-20 h-20 rounded-xl flex items-center justify-center" style="background: rgba(255,255,255,0.05);">
                                    <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-white">{{ $item['menu']->name }}</h4>
                                <p class="text-sm text-slate-400">{{ $item['menu']->formatted_price }} / porsi</p>
                                <div class="flex items-center gap-3 mt-3">
                                    <form action="{{ route('user.cart.update', $item['menu']) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99" class="w-16 text-center rounded-xl shadow-sm text-sm py-2" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                                        <button type="submit" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium transition">Update</button>
                                    </form>
                                    <form action="{{ route('user.cart.remove', $item['menu']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400 transition p-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-bold text-white">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Checkout Panel -->
            <div class="lg:col-span-1">
                <div class="rounded-2xl sticky top-24 overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                    <div class="p-6" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                        <h3 class="text-lg font-semibold text-white">Ringkasan</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-slate-400">Total</span>
                            <span class="text-2xl font-extrabold text-emerald-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <div class="p-3 rounded-xl {{ auth()->user()->balance >= $total ? 'bg-emerald-500/10 border border-emerald-500/20' : 'bg-red-500/10 border border-red-500/20' }} mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400">Saldo Anda</span>
                                <span class="font-semibold {{ auth()->user()->balance >= $total ? 'text-emerald-400' : 'text-red-400' }}">
                                    {{ auth()->user()->formatted_balance }}
                                </span>
                            </div>
                            @if(auth()->user()->balance < $total)
                                <p class="text-xs text-red-400 mt-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                    Saldo tidak cukup. <a href="{{ route('user.balance.index') }}" class="underline font-medium">Isi saldo</a>
                                </p>
                            @endif
                        </div>

                        <form action="{{ route('user.orders.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="pickup_time" class="block text-sm font-medium text-slate-300 mb-2">Waktu Pengambilan</label>
                                <div x-data="{ open: false, selected: '{{ old('pickup_time', '') }}', label: '{{ old('pickup_time') === 'istirahat_1' ? 'Istirahat 1' : (old('pickup_time') === 'istirahat_2' ? 'Istirahat 2' : 'Pilih Waktu') }}' }" class="relative">
                                    <input type="hidden" name="pickup_time" :value="selected" required>
                                    <button type="button" @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm text-left transition-all" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                                        <span :class="selected ? 'text-slate-200' : 'text-slate-500'" x-text="label"></span>
                                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute z-20 w-full mt-2 rounded-xl overflow-hidden shadow-xl shadow-black/30" style="background: #1e1b4b; border: 1px solid rgba(99,102,241,0.2);">
                                        <button type="button" @click="selected = 'istirahat_1'; label = 'Istirahat 1'; open = false" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-slate-300 hover:text-white transition-colors" :class="selected === 'istirahat_1' ? 'bg-indigo-500/20 text-indigo-300' : ''" style="border-bottom: 1px solid rgba(99,102,241,0.1);" onmouseover="this.style.background='rgba(99,102,241,0.15)'" onmouseout="this.style.background=selected === 'istirahat_1' ? 'rgba(99,102,241,0.2)' : ''">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Istirahat 1
                                        </button>
                                        <button type="button" @click="selected = 'istirahat_2'; label = 'Istirahat 2'; open = false" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-slate-300 hover:text-white transition-colors" :class="selected === 'istirahat_2' ? 'bg-indigo-500/20 text-indigo-300' : ''" onmouseover="this.style.background='rgba(99,102,241,0.15)'" onmouseout="this.style.background=selected === 'istirahat_2' ? 'rgba(99,102,241,0.2)' : ''">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Istirahat 2
                                        </button>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('pickup_time')" class="mt-2" />
                            </div>

                            <div class="mb-6">
                                <label for="notes" class="block text-sm font-medium text-slate-300 mb-2">Catatan (Opsional)</label>
                                <textarea id="notes" name="notes" rows="2" class="block w-full rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;" placeholder="Contoh: Tidak pakai sambal">{{ old('notes') }}</textarea>
                            </div>

                            <button type="submit" {{ auth()->user()->balance < $total ? 'disabled' : '' }} class="w-full px-6 py-3 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Pesan Sekarang
                            </button>
                        </form>

                        <a href="{{ route('user.menu.index') }}" class="block text-center text-sm text-slate-400 hover:text-indigo-400 font-medium mt-4 transition">Lanjut Belanja</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
