@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full px-4 py-3 bg-white border border-stone-200 rounded-lg text-ink text-sm placeholder-stone-400 focus:border-ink focus:ring-1 focus:ring-ink focus:outline-none transition duration-200 ease-in-out disabled:bg-stone-50 disabled:text-stone-400']) }}>
