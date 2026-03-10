<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="rounded-2xl p-8 text-center" style="background: rgba(30,27,75,0.5); border: 1px solid rgba(99,102,241,0.12);">
        <p class="text-slate-300">{{ __("You're logged in!") }}</p>
    </div>
</x-app-layout>
