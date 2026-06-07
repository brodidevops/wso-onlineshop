<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <!-- Login Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden">
        <div class="p-8 sm:p-10">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-ink/5 mb-4">
                    <svg class="w-7 h-7 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-ink">Sign in to your account</h2>
                <p class="text-sm text-stone-500 mt-1.5">Enter your credentials to continue</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-5">
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2.5">
                        <input type="checkbox" name="remember" class="rounded border-stone-300 text-ink focus:ring-ink h-4 w-4">
                        <span class="text-sm text-stone-600">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-ink hover:text-ink-soft transition-colors" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <x-primary-button>
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Sign In
                </x-primary-button>
            </form>
        </div>

        <!-- Footer -->
        <div class="px-8 py-5 bg-stone-50 border-t border-stone-100 text-center">
            <p class="text-sm text-stone-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-ink hover:text-ink-soft transition-colors">Create one</a>
            </p>
        </div>
    </div>
</x-guest-layout>
