<x-app-layout>
<x-slot name="header"> 
        Pengaturan Profil
     </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="rounded-2xl p-6 sm:p-8" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="rounded-2xl p-6 sm:p-8" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            @include('profile.partials.update-password-form')
        </div>

        <div class="rounded-2xl p-6 sm:p-8" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
