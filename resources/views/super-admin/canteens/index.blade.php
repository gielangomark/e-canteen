<x-app-layout>
<x-slot name="header">Kelola Kantin</x-slot>

    <div class="flex justify-end mb-6">
        <a href="{{ route('super-admin.canteens.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Kantin
        </a>
    </div>

    @if($canteens->isEmpty())
        <div class="rounded-2xl p-16 text-center" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center mx-auto mb-5">
                <span class="text-4xl">🏪</span>
            </div>
            <p class="text-lg font-semibold text-slate-300">Belum ada kantin</p>
            <p class="text-sm text-slate-500 mt-1">Mulai tambahkan kantin pertama!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($canteens as $canteen)
                <div class="rounded-2xl overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
                    @if($canteen->image)
                        <img src="{{ asset('storage/' . $canteen->image) }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 gradient-primary flex items-center justify-center">
                            <span class="text-5xl font-bold text-white/30">{{ strtoupper(substr($canteen->name, 0, 2)) }}</span>
                        </div>
                    @endif
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-lg font-bold text-white">{{ $canteen->name }}</h3>
                            <span class="w-2.5 h-2.5 rounded-full {{ $canteen->is_active ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                        </div>
                        <p class="text-sm text-slate-400 mb-3">Penjual: {{ $canteen->seller->name ?? '-' }}</p>
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="rounded-lg p-2 text-center" style="background: rgba(99,102,241,0.08);">
                                <p class="text-lg font-bold text-white">{{ $canteen->menus_count }}</p>
                                <p class="text-[10px] text-slate-400">Menu</p>
                            </div>
                            <div class="rounded-lg p-2 text-center" style="background: rgba(16,185,129,0.08);">
                                <p class="text-sm font-bold text-emerald-400">Rp {{ number_format($canteen->balance, 0, ',', '.') }}</p>
                                <p class="text-[10px] text-slate-400">Saldo</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('super-admin.canteens.edit', $canteen) }}" class="flex-1 text-center px-3 py-2 bg-indigo-500/10 text-indigo-400 text-sm font-medium rounded-lg hover:bg-indigo-500/20 transition">Edit</a>
                            <form action="{{ route('super-admin.canteens.destroy', $canteen) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus kantin ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full px-3 py-2 bg-red-500/10 text-red-400 text-sm font-medium rounded-lg hover:bg-red-500/20 transition">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
