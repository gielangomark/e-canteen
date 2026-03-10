<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('seller.menus.index') }}" class="p-2 rounded-lg text-slate-500 hover:bg-white/5 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <span>Edit Menu: {{ $menu->name }}</span>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <form action="{{ route('seller.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-300 mb-1.5">Nama Menu</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $menu->name) }}" required
                            class="w-full rounded-xl shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 py-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-semibold text-slate-300 mb-1.5">Kategori</label>
                        <select id="category" name="category" class="w-full rounded-xl shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 py-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                            <option value="makanan" {{ old('category', $menu->category) === 'makanan' ? 'selected' : '' }}>🍚 Makanan</option>
                            <option value="minuman" {{ old('category', $menu->category) === 'minuman' ? 'selected' : '' }}>🥤 Minuman</option>
                            <option value="snack" {{ old('category', $menu->category) === 'snack' ? 'selected' : '' }}>🍿 Snack</option>
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-semibold text-slate-300 mb-1.5">Harga (Rp)</label>
                        <input id="price" name="price" type="number" value="{{ old('price', $menu->price) }}" min="0" step="500" required
                            class="w-full rounded-xl shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 py-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-300 mb-1.5">Deskripsi</label>
                        <textarea id="description" name="description" rows="3" class="w-full rounded-xl shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">{{ old('description', $menu->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <div>
                        <label for="image" class="block text-sm font-semibold text-slate-300 mb-1.5">Foto Menu</label>
                        @if($menu->image)
                            <div class="mb-3 flex items-center gap-4">
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-20 h-20 object-cover rounded-xl border-2 border-indigo-500/20">
                                <p class="text-xs text-slate-400">Foto saat ini</p>
                            </div>
                        @endif
                        <input id="image" name="image" type="file" accept="image/*" class="w-full text-sm text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-500/20 file:text-indigo-300 hover:file:bg-indigo-500/30 file:transition" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                    <div>
                        <label class="inline-flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_available" value="1" {{ old('is_available', $menu->is_available) ? 'checked' : '' }} class="w-5 h-5 rounded-lg border-white/20 bg-white/5 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="text-sm font-medium text-slate-300">Tersedia untuk dipesan</span>
                        </label>
                    </div>
                </div>
                <div class="flex items-center gap-4 mt-8 pt-6" style="border-top: 1px solid rgba(99,102,241,0.1);">
                    <button type="submit" class="px-6 py-3 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all">Perbarui Menu</button>
                    <a href="{{ route('seller.menus.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-200 transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
