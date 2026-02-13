<x-guest-layout>

    <h1 class="text-center text-lg font-semibold mb-4">
        Login
    </h1>

    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">

        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input
                id="email"
                class="w-full"
                type="email"
                name="email"
                required
                autofocus
            />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input
                id="password"
                class="w-full"
                type="password"
                name="password"
                required
            />
        </div>

        <x-primary-button class="w-full justify-center mt-2">
            Login
        </x-primary-button>

        @if (Route::has('register'))
            <p class="text-center text-xs text-gray-600 mt-3">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-indigo-600 underline">
                    Register
                </a>
            </p>
        @endif
    </form>

</x-guest-layout>
