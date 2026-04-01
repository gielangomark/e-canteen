<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('user.menu.index') }}" class="p-2 rounded-lg text-slate-500 hover:bg-white/5 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <span>Pencarian Menu</span>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Search Bar -->
        <form action="{{ route('user.menu.search') }}" method="GET" class="relative">
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ $query }}" placeholder="Cari menu, kantin, atau kategori..." autofocus
                    class="w-full pl-12 pr-12 py-3.5 rounded-2xl text-white placeholder-slate-500 text-base focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all"
                    style="background: rgba(30,27,75,0.6); border: 1px solid rgba(99,102,241,0.2);">
                @if($query)
                    <a href="{{ route('user.menu.search') }}" class="absolute right-14 top-1/2 -translate-y-1/2 p-1.5 rounded-lg text-slate-500 hover:text-white hover:bg-white/5 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 gradient-primary rounded-xl text-white shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </div>
        </form>

        <!-- Results Header -->
        @if($query)
            <div class="flex items-center gap-2 text-sm text-slate-400">
                <span>Hasil pencarian untuk</span>
                <span class="px-2.5 py-1 rounded-lg font-semibold text-indigo-300" style="background: rgba(99,102,241,0.15);">"{{ $query }}"</span>
                <span>&mdash; {{ $menus->count() }} menu ditemukan</span>
            </div>
        @endif

        <!-- Results Grid -->
        @if($menus->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($menus as $menu)
                    <div class="group rounded-2xl overflow-hidden hover:shadow-xl hover:shadow-indigo-500/10 transition-all duration-300" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                        <!-- Image -->
                        <div class="relative overflow-hidden aspect-[4/3]">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center" style="background: rgba(255,255,255,0.03);">
                                    <svg class="w-12 h-12 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3 flex gap-2">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg backdrop-blur-sm
                                    @if($menu->category === 'makanan') bg-orange-500/20 text-orange-300
                                    @elseif($menu->category === 'minuman') bg-blue-500/20 text-blue-300
                                    @else bg-pink-500/20 text-pink-300
                                    @endif
                                ">{{ ucfirst($menu->category) }}</span>
                            </div>
                            <div class="absolute bottom-3 left-3">
                                <a href="{{ route('user.menu.canteen', $menu->canteen) }}" class="px-2.5 py-1 text-xs font-semibold rounded-lg backdrop-blur-md text-white hover:text-indigo-300 transition" style="background: rgba(0,0,0,0.5);">
                                    {{ $menu->canteen->name }}
                                </a>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-4">
                            <h3 class="font-bold text-white text-lg mb-1 truncate">{{ $menu->name }}</h3>
                            @if($menu->description)
                                <p class="text-sm text-slate-400 mb-3 line-clamp-2">{{ $menu->description }}</p>
                            @endif
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-lg font-extrabold text-emerald-400">{{ $menu->formatted_price }}</span>
                                <form action="{{ route('user.cart.add', $menu) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input type="number" name="quantity" value="1" min="1" max="99" class="w-14 text-center rounded-lg text-sm py-1.5" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                                    <button type="submit" class="p-2.5 gradient-primary text-white rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all duration-300" title="Tambah ke keranjang">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                    </button>
                                </form>
                            </div>
                            @if(isset($cart[$menu->id]))
                                <p class="text-xs text-indigo-400 mt-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    {{ $cart[$menu->id] }} di keranjang
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif($query)
            <div class="text-center py-16">
                <svg class="w-20 h-20 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <p class="text-xl font-semibold text-slate-400 mb-2">Tidak ditemukan</p>
                <p class="text-sm text-slate-500 mb-6">Tidak ada menu yang cocok dengan "{{ $query }}"</p>
                <a href="{{ route('user.menu.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Kantin
                </a>
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-20 h-20 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <p class="text-xl font-semibold text-slate-400 mb-2">Cari Menu Favorit</p>
                <p class="text-sm text-slate-500">Ketik nama menu, kantin, atau kategori di kolom pencarian.</p>
            </div>
        @endif
    </div>

    <!-- Floating Cart Button -->
    @php $cartCount = array_sum(session()->get('cart', [])); @endphp
    @if($cartCount > 0)
        <a href="{{ route('user.cart.index') }}" class="fixed bottom-6 right-6 z-50 gradient-primary text-white px-6 py-3 rounded-2xl shadow-xl shadow-indigo-500/30 hover:shadow-indigo-500/50 flex items-center gap-3 transition-all duration-300 hover:scale-105">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
            <span class="font-bold">Keranjang</span>
            <span class="bg-white/20 backdrop-blur-sm px-2.5 py-0.5 rounded-lg text-sm font-bold">{{ $cartCount }}</span>
        </a>
    @endif
</x-app-layout>
