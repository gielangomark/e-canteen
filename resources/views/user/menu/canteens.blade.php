<x-app-layout>
    <x-slot name="header">Pilih Kantin</x-slot>

    @if($canteens->isEmpty())
        <div class="text-center py-16">
            <svg class="w-20 h-20 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <p class="text-xl font-semibold text-slate-400 mb-2">Belum ada kantin tersedia</p>
            <p class="text-sm text-slate-500">Tunggu kantin dibuka oleh admin.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($canteens as $canteen)
                <a href="{{ route('user.menu.canteen', $canteen) }}" class="group rounded-2xl overflow-hidden hover:shadow-xl hover:shadow-indigo-500/10 hover:-translate-y-1 transition-all duration-300" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                    @if($canteen->image)
                        <img src="{{ asset('storage/' . $canteen->image) }}" alt="{{ $canteen->name }}" class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-44 gradient-primary flex items-center justify-center relative overflow-hidden">
                            <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-white/20"></div>
                            <div class="absolute -bottom-8 -left-8 w-32 h-32 rounded-full bg-white/10"></div>
                            <span class="text-5xl font-bold text-white/30 relative z-10">{{ strtoupper(substr($canteen->name, 0, 2)) }}</span>
                        </div>
                    @endif
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-white mb-1 group-hover:text-indigo-300 transition">{{ $canteen->name }}</h3>
                        @if($canteen->description)
                            <p class="text-sm text-slate-400 mb-3 line-clamp-2">{{ $canteen->description }}</p>
                        @endif
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 text-sm text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                {{ $canteen->menus_count }} menu
                            </span>
                            <span class="inline-flex items-center gap-1 text-sm font-medium text-indigo-400 group-hover:translate-x-1 transition-transform">
                                Lihat Menu
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

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
