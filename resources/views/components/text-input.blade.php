@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-xl shadow-sm text-sm py-3 focus:border-indigo-500 focus:ring-indigo-500', 'style' => 'background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;']) }}>
