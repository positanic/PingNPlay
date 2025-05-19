<x-app-layout>
    <h1 class="text-center">Register</h1>
    <div class="container w-50 ml-auto mr-auto">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            

            <!-- Name -->
            <div class="row">
                <div class="col-2 text-end"><x-input-label for="name" :value="__('Name')" /></div>
                <div class="col-10"><x-text-input id="name" class="block mt-1 w-100" type="text" name="name" :value="old('name')" required autofocus /></div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <!-- Email Address -->
            <div class="row mt-4">
                <div class="col-2 text-end"><x-input-label for="email" :value="__('Email')" /></div>
                <div class="col-10"><x-text-input id="email" class="block mt-1 w-100" type="email" name="email" :value="old('email')" required /></div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="row mt-4">
                <div class="col-2 text-end"><x-input-label for="password" :value="__('Password')" /></div>

                <div class="col-10"><x-text-input id="password" class="block mt-1 w-100"
                                type="password"
                                name="password"
                                required autocomplete="new-password" /> </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="row mt-4">
                <div class="col-2 text-end"><x-input-label for="password_confirmation" :value="__('Confirm Password')" /></div>

                <div class="col-10"><x-text-input id="password_confirmation" class="block mt-1 w-100"
                                type="password"
                                name="password_confirmation" required /> </div>

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-4 ms-auto me-auto">
                <a class="text-decoration-underline small link-secondary hover:link-dark" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
