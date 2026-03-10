<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-white">Reset Password 🔒</h2>
        <p class="text-sm text-slate-400 mt-2">Masukkan password baru untuk akun Anda</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                    class="auth-input w-full rounded-xl text-sm py-3 px-4">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-300 mb-2">Password Baru</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="auth-input w-full rounded-xl text-sm py-3 px-4">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-300 mb-2">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="auth-input w-full rounded-xl text-sm py-3 px-4">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit" class="w-full py-3.5 glow-btn text-white font-bold rounded-xl text-sm">
                Reset Password
            </button>
        </div>
    </form>
</x-guest-layout>
