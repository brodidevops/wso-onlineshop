<x-guest-layout>
    <!-- Register Form -->
    <div class="w-full">
        <!-- Form Header -->
        <div class="mb-8 text-center">
            <h2 class="text-2xl font-bold text-ink mb-2">
                Create Account
            </h2>
            <p class="text-silver text-sm">Join us and start shopping today</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-6 p-3 rounded-lg bg-accent-50 border border-accent-200 text-accent-700 text-sm text-center" :status="session('status')" />

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-ink">
                    Full Name
                </label>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                    class="w-full px-4 py-2.5 bg-white border border-stone-200 text-ink placeholder-mist rounded-lg text-sm focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink transition-colors"
                    placeholder="John Doe">
                <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-red-600 text-xs" />
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-ink">
                    Email Address
                </label>
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                    class="w-full px-4 py-2.5 bg-white border border-stone-200 text-ink placeholder-mist rounded-lg text-sm focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink transition-colors"
                    placeholder="your.email@example.com">
                <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-red-600 text-xs" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-ink">
                    Password
                </label>
                <div class="relative" x-data="{ show: false }">
                    <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-2.5 pr-11 bg-white border border-stone-200 text-ink placeholder-mist rounded-lg text-sm focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink transition-colors"
                        placeholder="Min. 8 characters">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-mist hover:text-ink transition-colors">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-red-600 text-xs" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="block text-sm font-medium text-ink">
                    Confirm Password
                </label>
                <div class="relative" x-data="{ show: false }">
                    <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                        class="w-full px-4 py-2.5 pr-11 bg-white border border-stone-200 text-ink placeholder-mist rounded-lg text-sm focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink transition-colors"
                        placeholder="Repeat your password">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-mist hover:text-ink transition-colors">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-red-600 text-xs" />
            </div>

            <!-- Terms -->
            <div class="flex items-start gap-2.5 pt-1">
                <input id="terms" type="checkbox" required
                    class="w-4 h-4 mt-0.5 bg-white border-stone-300 rounded text-ink focus:ring-2 focus:ring-ink focus:ring-offset-0 transition-colors cursor-pointer">
                <label for="terms" class="text-sm text-silver leading-relaxed cursor-pointer">
                    I agree to the
                    <a href="#" class="text-ink hover:text-graphite transition-colors">Terms of Service</a>
                    and
                    <a href="#" class="text-ink hover:text-graphite transition-colors">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-ink text-white py-2.5 rounded-lg font-medium text-sm hover:bg-graphite transition-colors duration-200 flex items-center justify-center gap-2">
                Create Account
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-stone-200"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="px-4 text-xs text-mist bg-white uppercase tracking-wider">
                    or continue with
                </span>
            </div>
        </div>

        <!-- Social Login -->
        <div class="grid grid-cols-2 gap-3">
            <button class="px-4 py-2.5 bg-white border border-stone-200 rounded-lg hover:bg-stone-50 transition-colors flex items-center justify-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="text-sm font-medium text-ink">Google</span>
            </button>
            <button class="px-4 py-2.5 bg-white border border-stone-200 rounded-lg hover:bg-stone-50 transition-colors flex items-center justify-center gap-2">
                <svg class="w-5 h-5 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                </svg>
                <span class="text-sm font-medium text-ink">Facebook</span>
            </button>
        </div>

        <!-- Login Link -->
        <p class="text-center mt-6 text-sm text-silver">
            Already have an account?
            <a href="{{ route('login') }}"
                class="font-medium text-ink hover:text-graphite transition-colors">
                Sign in now
            </a>
        </p>
    </div>
</x-guest-layout>