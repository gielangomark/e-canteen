<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('seller.menus.index') }}" class="p-2 rounded-lg text-slate-500 hover:bg-white/5 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <span>Tambah Menu Baru</span>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <form action="{{ route('seller.menus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-300 mb-1.5">Nama Menu</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required
                            class="w-full rounded-xl shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 py-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-semibold text-slate-300 mb-1.5">Kategori</label>
                        <select id="category" name="category" class="w-full rounded-xl shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 py-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                            <option value="">Pilih Kategori</option>
                            <option value="makanan" {{ old('category') === 'makanan' ? 'selected' : '' }}>🍚 Makanan</option>
                            <option value="minuman" {{ old('category') === 'minuman' ? 'selected' : '' }}>🥤 Minuman</option>
                            <option value="snack" {{ old('category') === 'snack' ? 'selected' : '' }}>🍿 Snack</option>
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-semibold text-slate-300 mb-1.5">Harga (Rp)</label>
                        <input id="price" name="price" type="number" value="{{ old('price') }}" min="0" step="500" required
                            class="w-full rounded-xl shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 py-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-300 mb-1.5">Deskripsi (Opsional)</label>
                        <textarea id="description" name="description" rows="3" class="w-full rounded-xl shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <div>
                        <label for="image" class="block text-sm font-semibold text-slate-300 mb-1.5">Foto Menu</label>
                        <input id="image" name="image" type="file" accept="image/*" class="w-full text-sm text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-500/20 file:text-indigo-300 hover:file:bg-indigo-500/30 file:transition" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                    <div>
                        <label class="inline-flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_available" value="1" checked class="w-5 h-5 rounded-lg border-white/20 bg-white/5 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="text-sm font-medium text-slate-300">Tersedia untuk dipesan</span>
                        </label>
                    </div>
                </div>
                <div class="flex items-center gap-4 mt-8 pt-6" style="border-top: 1px solid rgba(99,102,241,0.1);">
                    <button type="submit" class="px-6 py-3 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all">Simpan Menu</button>
                    <a href="{{ route('seller.menus.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-200 transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
