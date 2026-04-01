<x-app-layout>
<x-slot name="header">Kelola User</x-slot>

    <!-- Filter & Search -->
    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <form action="{{ route('super-admin.users.index') }}" method="GET" class="flex-1 flex gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition"
                    style="background: rgba(30,27,75,0.6); border: 1px solid rgba(99,102,241,0.2);">
            </div>
            <select name="role" onchange="this.form.submit()"
                class="px-4 py-2.5 rounded-xl text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition"
                style="background: rgba(30,27,75,0.6); border: 1px solid rgba(99,102,241,0.2);">
                <option value="">Semua Role</option>
                <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="seller" {{ request('role') === 'seller' ? 'selected' : '' }}>Seller</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
            </select>
            <button type="submit" class="px-4 py-2.5 gradient-primary text-white rounded-xl text-sm font-semibold shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all">
                Cari
            </button>
        </form>
        <a href="{{ route('super-admin.users.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah User
        </a>
    </div>

    <!-- User Table -->
    <div class="rounded-2xl overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr style="background: rgba(99,102,241,0.08);">
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Role</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Saldo</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Terdaftar</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $user)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="px-5 py-4 text-slate-500">{{ $users->firstItem() + $loop->index }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold text-white" style="background: linear-gradient(135deg, #818cf8, #7c3aed);">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <span class="font-semibold text-white">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-slate-400">{{ $user->email }}</td>
                            <td class="px-5 py-4">
                                @if($user->role === 'super_admin')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-red-500/15 text-red-400">Super Admin</span>
                                @elseif($user->role === 'seller')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-amber-500/15 text-amber-400">Seller</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-emerald-500/15 text-emerald-400">User</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-emerald-400 font-semibold">Rp {{ number_format($user->balance, 0, ',', '.') }}</td>
                            <td class="px-5 py-4 text-slate-500 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('super-admin.users.edit', $user) }}" class="p-2 rounded-lg bg-indigo-500/10 text-indigo-400 hover:bg-indigo-500/20 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('super-admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center">
                                <svg class="w-16 h-16 text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                <p class="text-lg font-semibold text-slate-400">Tidak ada user ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-5 py-4" style="border-top: 1px solid rgba(99,102,241,0.1);">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Summary -->
    <div class="mt-4 text-sm text-slate-500">
        Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} user
    </div>
</x-app-layout>
