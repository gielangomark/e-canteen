<x-app-layout>
<x-slot name="header">Kelola Menu</x-slot>

    <!-- Category Stats -->
    @if(!$menus->isEmpty())
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="rounded-2xl p-4 flex items-center gap-3" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                <div class="w-11 h-11 bg-white/5 rounded-xl flex items-center justify-center"><span class="text-lg">📋</span></div>
                <div>
                    <p class="text-2xl font-extrabold text-white">{{ $menus->count() }}</p>
                    <p class="text-xs text-slate-400">Total Menu</p>
                </div>
            </div>
            <div class="rounded-2xl p-4 flex items-center gap-3" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                <div class="w-11 h-11 bg-orange-500/10 rounded-xl flex items-center justify-center"><span class="text-lg">🍚</span></div>
                <div>
                    <p class="text-2xl font-extrabold text-orange-400">{{ $menus->where('category', 'makanan')->count() }}</p>
                    <p class="text-xs text-slate-400">Makanan</p>
                </div>
            </div>
            <div class="rounded-2xl p-4 flex items-center gap-3" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                <div class="w-11 h-11 bg-blue-500/10 rounded-xl flex items-center justify-center"><span class="text-lg">🥤</span></div>
                <div>
                    <p class="text-2xl font-extrabold text-blue-400">{{ $menus->where('category', 'minuman')->count() }}</p>
                    <p class="text-xs text-slate-400">Minuman</p>
                </div>
            </div>
            <div class="rounded-2xl p-4 flex items-center gap-3" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                <div class="w-11 h-11 bg-purple-500/10 rounded-xl flex items-center justify-center"><span class="text-lg">🍿</span></div>
                <div>
                    <p class="text-2xl font-extrabold text-purple-400">{{ $menus->where('category', 'snack')->count() }}</p>
                    <p class="text-xs text-slate-400">Snack</p>
                </div>
            </div>
        </div>
    @endif

    @if($menus->isEmpty())
        <div class="rounded-2xl p-16 text-center" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center mx-auto mb-5"><span class="text-4xl">🍽️</span></div>
            <p class="text-lg font-semibold text-slate-300">Belum ada menu</p>
            <p class="text-sm text-slate-500 mt-1 mb-6">Mulai tambahkan menu kantin Anda!</p>
            <a href="{{ route('seller.menus.create') }}" class="inline-flex items-center gap-2 px-6 py-3 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Menu Pertama
            </a>
        </div>
    @else
        <div class="mb-5 flex justify-end">
            <a href="{{ route('seller.menus.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 gradient-primary text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Menu
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($menus as $menu)
                <div class="group rounded-2xl overflow-hidden hover:shadow-xl hover:shadow-indigo-500/10 hover:-translate-y-1 transition-all duration-300" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                    <div class="relative h-44 overflow-hidden">
                        @if($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center relative overflow-hidden
                                {{ $menu->category === 'makanan' ? 'bg-gradient-to-br from-orange-700 via-amber-600 to-yellow-500' : '' }}
                                {{ $menu->category === 'minuman' ? 'bg-gradient-to-br from-blue-700 via-cyan-600 to-teal-500' : '' }}
                                {{ $menu->category === 'snack' ? 'bg-gradient-to-br from-purple-700 via-pink-600 to-rose-500' : '' }}
                            ">
                                <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-white/20"></div>
                                <div class="absolute -bottom-8 -left-8 w-32 h-32 rounded-full bg-white/10"></div>
                                <span class="text-7xl drop-shadow-lg group-hover:scale-125 transition-transform duration-500 relative z-10">
                                    {{ $menu->category === 'makanan' ? '🍛' : ($menu->category === 'minuman' ? '🧃' : '🍿') }}
                                </span>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold backdrop-blur-md shadow-sm
                                {{ $menu->category === 'makanan' ? 'bg-orange-500/90 text-white' : '' }}
                                {{ $menu->category === 'minuman' ? 'bg-blue-500/90 text-white' : '' }}
                                {{ $menu->category === 'snack' ? 'bg-purple-500/90 text-white' : '' }}
                            ">{{ ucfirst($menu->category) }}</span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <form action="{{ route('seller.menus.toggle', $menu) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold cursor-pointer backdrop-blur-md shadow-sm transition-all hover:scale-105
                                    {{ $menu->is_available ? 'bg-emerald-500/90 text-white' : 'bg-red-500/90 text-white' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $menu->is_available ? 'bg-emerald-200' : 'bg-red-200' }}"></span>
                                    {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <h3 class="font-bold text-white text-base leading-snug">{{ $menu->name }}</h3>
                            <span class="text-lg font-extrabold text-emerald-400 whitespace-nowrap">{{ $menu->formatted_price }}</span>
                        </div>
                        @if($menu->description)
                            <p class="text-sm text-slate-400 leading-relaxed mb-4">{{ Str::limit($menu->description, 80) }}</p>
                        @else
                            <p class="text-sm text-slate-500 italic mb-4">Tidak ada deskripsi</p>
                        @endif
                        <div class="flex items-center gap-2 pt-3" style="border-top: 1px solid rgba(99,102,241,0.1);">
                            <a href="{{ route('seller.menus.edit', $menu) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-500/10 text-indigo-400 text-sm font-semibold rounded-xl hover:bg-indigo-500/20 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('seller.menus.destroy', $menu) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu {{ $menu->name }}?')" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-500/10 text-red-400 text-sm font-semibold rounded-xl hover:bg-red-500/20 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
