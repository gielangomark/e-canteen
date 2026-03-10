<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 rounded-xl font-semibold text-xs text-slate-300 uppercase tracking-widest shadow-sm hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150', 'style' => 'background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);']) }}>
    {{ $slot }}
</button>
