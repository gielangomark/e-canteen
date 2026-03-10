<x-app-layout>
    <x-slot name="header">
        Isi Saldo
    </x-slot>

    <!-- Balance Card -->
    <div class="relative overflow-hidden rounded-2xl gradient-success p-8 mb-8 text-white shadow-lg shadow-emerald-500/25">
        <div class="relative z-10">
            <div class="flex items-center gap-2 text-white/70 mb-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span class="text-sm font-medium">Saldo Anda</span>
            </div>
            <p class="text-4xl font-extrabold">{{ $user->formatted_balance }}</p>
        </div>
        <div class="absolute -right-8 -top-8 w-40 h-40 bg-white/10 rounded-full"></div>
        <div class="absolute -right-4 -bottom-12 w-32 h-32 bg-white/5 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top-up Form -->
        <div class="rounded-2xl overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="p-6" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                <h3 class="text-lg font-semibold text-white">Ajukan Isi Saldo</h3>
                <p class="text-sm text-slate-400 mt-1">Saldo masuk setelah disetujui admin</p>
            </div>
            <div class="p-6">
                <form action="{{ route('user.balance-requests.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="amount" value="Jumlah (Rp)" />
                        <x-text-input id="amount" name="amount" type="number" class="mt-2 block w-full" :value="old('amount')" min="1000" step="1000" placeholder="Masukkan jumlah" required />
                        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                    </div>

                    <!-- Quick amounts -->
                    <div class="mb-6">
                        <p class="text-xs font-medium text-slate-400 mb-2">Pilih Cepat</p>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach ([10000, 20000, 50000, 100000] as $amount)
                                <button type="button" onclick="document.getElementById('amount').value = {{ $amount }}" class="px-4 py-2.5 text-sm font-medium text-slate-300 rounded-xl transition-all border border-indigo-500/20 hover:border-indigo-500/40 hover:text-indigo-400" style="background: rgba(255,255,255,0.05);">
                                    Rp {{ number_format($amount, 0, ',', '.') }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="w-full px-6 py-3 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all duration-300">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Ajukan Isi Saldo
                        </span>
                    </button>
                </form>
            </div>
        </div>

        <!-- History -->
        <div class="rounded-2xl overflow-hidden" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            <div class="p-6" style="border-bottom: 1px solid rgba(99,102,241,0.1);">
                <h3 class="text-lg font-semibold text-white">Riwayat Isi Saldo</h3>
            </div>

            @if($requests->isEmpty())
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-slate-400 font-medium">Belum ada riwayat</p>
                    <p class="text-sm text-slate-500 mt-1">Mulai isi saldo pertama Anda!</p>
                </div>
            @else
                <div class="divide-y divide-white/5">
                    @foreach ($requests as $req)
                        <div class="flex items-center justify-between px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $req->status === 'approved' ? 'bg-emerald-500/10' : ($req->status === 'rejected' ? 'bg-red-500/10' : 'bg-yellow-500/10') }}">
                                    @if($req->status === 'approved')
                                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @elseif($req->status === 'rejected')
                                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    @else
                                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-white">+{{ $req->formatted_amount }}</p>
                                    <p class="text-xs text-slate-400">{{ $req->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $req->status === 'approved' ? 'bg-emerald-500/15 text-emerald-400' : '' }}
                                {{ $req->status === 'rejected' ? 'bg-red-500/15 text-red-400' : '' }}
                                {{ $req->status === 'pending' ? 'bg-yellow-500/15 text-yellow-400' : '' }}
                            ">
                                {{ $req->status_label }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="px-6 py-4" style="border-top: 1px solid rgba(99,102,241,0.1);">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
