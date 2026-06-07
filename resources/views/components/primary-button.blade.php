<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center w-full px-5 py-3 bg-ink border border-transparent rounded-lg font-semibold text-sm text-white tracking-wide hover:bg-ink-soft focus:bg-ink-soft active:bg-ink focus:outline-none focus:ring-2 focus:ring-ink focus:ring-offset-2 transition ease-in-out duration-200 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
