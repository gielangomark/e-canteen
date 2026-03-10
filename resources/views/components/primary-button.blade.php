<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 text-xs uppercase tracking-widest transition-all ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
