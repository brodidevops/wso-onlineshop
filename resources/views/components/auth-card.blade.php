<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-lg rounded-lg p-8">
            {{ $slot }}
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                &larr; Back to home
            </a>
        </div>
    </div>
</div>