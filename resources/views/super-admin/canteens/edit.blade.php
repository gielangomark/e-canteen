<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('super-admin.canteens.index') }}" class="p-2 rounded-lg text-slate-500 hover:bg-white/5 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <span>Edit Kantin: {{ $canteen->name }}</span>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="rounded-2xl p-6" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <form action="{{ route('super-admin.canteens.update', $canteen) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-300 mb-1.5">Nama Kantin</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $canteen->name) }}" required
                            class="w-full rounded-xl shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 py-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-300 mb-1.5">Deskripsi</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full rounded-xl shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">{{ old('description', $canteen->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-semibold text-slate-300 mb-1.5">Foto Kantin</label>
                        @if($canteen->image)
                            <img src="{{ asset('storage/' . $canteen->image) }}" class="w-32 h-20 object-cover rounded-lg mb-2">
                        @endif
                        <input id="image" name="image" type="file" accept="image/*"
                            class="w-full text-sm text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-500/20 file:text-indigo-300 hover:file:bg-indigo-500/30 file:transition" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="inline-flex items-center gap-3 cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $canteen->is_active) ? 'checked' : '' }}
                                class="rounded border-white/20 bg-white/10 text-indigo-500 focus:ring-indigo-500">
                            <span class="text-sm text-slate-300">Aktifkan kantin</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4" style="border-top: 1px solid rgba(99,102,241,0.1);">
                        <a href="{{ route('super-admin.canteens.index') }}" class="px-5 py-2.5 bg-white/5 text-slate-400 font-medium rounded-xl hover:bg-white/10 transition text-sm">Batal</a>
                        <button type="submit" class="px-5 py-2.5 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all text-sm">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
