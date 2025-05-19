<x-app-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h1 class="text-center">Login</h1>
    <div class="container w-50 ml-auto mr-auto">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="row">
            <div class="col-2 text-end"><x-input-label for="email" :value="__('Email')" /></div>
            <div class="col-10"><x-text-input id="email" class="block mt-1 w-100" type="email" name="email" :value="old('email')" required autofocus /></div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="row mt-4">
            <div class="col-2 text-end"><x-input-label for="password" :value="__('Password')" /></div>

            <div class="col-10"><x-text-input id="password" class="block mt-1 w-100"
                            type="password"
                            name="password"
                            required autocomplete="current-password" /></div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 small text-muted">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="d-flex align-items-center justify-content-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline small text-muted hover:text-primary mx-4" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
