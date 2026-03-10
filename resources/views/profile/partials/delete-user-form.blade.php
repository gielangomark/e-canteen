<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-red-400">
            Hapus Akun
        </h2>
        <p class="mt-1 text-sm text-slate-400">
            Setelah akun Anda dihapus, semua data akan dihapus secara permanen. Pastikan Anda sudah menyimpan data yang diperlukan.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Hapus Akun</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-white">
                Apakah Anda yakin ingin menghapus akun?
            </h2>

            <p class="mt-2 text-sm text-slate-400">
                Setelah akun dihapus, semua data akan dihapus secara permanen. Masukkan password untuk konfirmasi.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full"
                    placeholder="Password"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-danger-button>Hapus Akun</x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
