<x-app-layout>
<x-slot name="header">
    <div class="flex items-center gap-3">
        <a href="{{ route('super-admin.users.index') }}" class="p-2 rounded-lg text-slate-500 hover:bg-white/5 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <span>Tambah User</span>
    </div>
</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="rounded-2xl p-6 sm:p-8" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <form action="{{ route('super-admin.users.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition"
                        style="background: rgba(255,255,255,0.05); border: 1px solid rgba(99,102,241,0.2);">
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition"
                        style="background: rgba(255,255,255,0.05); border: 1px solid rgba(99,102,241,0.2);">
                    @error('email') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Role</label>
                    <select name="role" required
                        class="w-full px-4 py-3 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition"
                        style="background: rgba(255,255,255,0.05); border: 1px solid rgba(99,102,241,0.2);">
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="seller" {{ old('role') === 'seller' ? 'selected' : '' }}>Seller</option>
                        <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Saldo -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Saldo (Rp)</label>
                    <input type="number" name="balance" value="{{ old('balance', 0) }}" min="0"
                        class="w-full px-4 py-3 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition"
                        style="background: rgba(255,255,255,0.05); border: 1px solid rgba(99,102,241,0.2);">
                    @error('balance') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition"
                        style="background: rgba(255,255,255,0.05); border: 1px solid rgba(99,102,241,0.2);">
                    @error('password') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-3 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition"
                        style="background: rgba(255,255,255,0.05); border: 1px solid rgba(99,102,241,0.2);">
                </div>

                <!-- Submit -->
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-3 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all text-sm">
                        Simpan User
                    </button>
                    <a href="{{ route('super-admin.users.index') }}" class="px-6 py-3 text-slate-400 font-semibold rounded-xl hover:bg-white/5 transition-all text-sm" style="border: 1px solid rgba(99,102,241,0.15);">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
