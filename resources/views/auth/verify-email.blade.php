<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-white">Verifikasi Email 📧</h2>
        <p class="text-sm text-slate-400 mt-2">Terima kasih telah mendaftar! Silakan verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-4 rounded-xl" style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2);">
            <p class="text-sm text-emerald-400 font-medium">Link verifikasi baru telah dikirim ke alamat email Anda.</p>
        </div>
    @endif

    <div class="flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="py-3 px-6 glow-btn text-white font-bold rounded-xl text-sm">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm font-medium text-slate-400 hover:text-slate-300 transition">
                Keluar
            </button>
        </form>
    </div>
</x-guest-layout>
