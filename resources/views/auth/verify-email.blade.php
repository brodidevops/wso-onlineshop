<x-guest-layout>
    <x-auth-card>
        <h2 class="text-xl font-bold text-gray-900 mb-2">Verify Email</h2>
        <p class="text-sm text-gray-500 mb-6">Please verify your email by clicking the link we sent you.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-md">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <div class="flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                    Resend Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-3 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 font-medium">
                    Log Out
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
