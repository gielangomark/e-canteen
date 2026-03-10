<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-white">Selamat Datang! 👋</h2>
        <p class="text-sm text-slate-400 mt-2">Masuk ke akun E-Canteen kamu</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="auth-input w-full rounded-xl text-sm py-3 pl-12 pr-4" placeholder="nama@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-300 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="auth-input w-full rounded-xl text-sm py-3 pl-12 pr-4" placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded-md border-slate-600 bg-white/5 text-indigo-500 focus:ring-indigo-500 focus:ring-offset-0">
                    <span class="text-sm text-slate-400">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-indigo-400 hover:text-indigo-300 transition" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full py-3.5 glow-btn text-white font-bold rounded-xl text-sm flex items-center justify-center gap-2 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                Masuk
            </button>
        </div>
    </form>

    <div class="relative my-7">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/5"></div></div>
        <div class="relative flex justify-center text-xs"><span class="px-3 bg-transparent text-slate-500 font-medium">atau</span></div>
    </div>

    <div class="text-center">
        <p class="text-sm text-slate-500">Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-indigo-400 hover:text-indigo-300 transition">Daftar sekarang</a></p>
    </div>
</x-guest-layout>
