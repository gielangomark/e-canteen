<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-white">Konfirmasi Password 🔐</h2>
        <p class="text-sm text-slate-400 mt-2">Ini adalah area aman. Silakan konfirmasi password Anda sebelum melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="space-y-5">
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-300 mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="auth-input w-full rounded-xl text-sm py-3 px-4">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <button type="submit" class="w-full py-3.5 glow-btn text-white font-bold rounded-xl text-sm">
                Konfirmasi
            </button>
        </div>
    </form>
</x-guest-layout>
