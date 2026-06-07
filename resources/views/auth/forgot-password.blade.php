<x-guest-layout>
    <x-auth-card>
        <h2 class="text-xl font-bold text-gray-900 mb-2">Forgot Password</h2>
        <p class="text-sm text-gray-500 mb-6">Enter your email and we'll send you a reset link.</p>

        @if (session('status'))
            <div class="mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-md">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                    Send Reset Link
                </button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
