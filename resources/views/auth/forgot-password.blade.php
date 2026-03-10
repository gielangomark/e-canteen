<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-white">Lupa Password? 🔑</h2>
        <p class="text-sm text-slate-400 mt-2">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="auth-input w-full rounded-xl text-sm py-3 pl-12 pr-4" placeholder="nama@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <button type="submit" class="w-full py-3.5 glow-btn text-white font-bold rounded-xl text-sm flex items-center justify-center gap-2 cursor-pointer">
                Kirim Link Reset Password
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-400 hover:text-indigo-300 transition">← Kembali ke Login</a>
    </div>
</x-guest-layout>
