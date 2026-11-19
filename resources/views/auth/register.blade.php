<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pe-20"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <button type="button" data-password-toggle="password"
                        class="absolute inset-y-0 end-0 mt-1 px-3 text-sm text-gray-600 hover:text-gray-900"
                        aria-controls="password" aria-label="Show password">
                    Show
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <ul class="mt-2 space-y-1 text-sm" aria-live="polite">
                <li id="password-length" class="text-gray-500">○ At least 8 characters</li>
                <li id="password-case" class="text-gray-500">○ Uppercase and lowercase letters</li>
                <li id="password-number" class="text-gray-500">○ At least one number</li>
            </ul>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full pe-20"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <button type="button" data-password-toggle="password_confirmation"
                        class="absolute inset-y-0 end-0 mt-1 px-3 text-sm text-gray-600 hover:text-gray-900"
                        aria-controls="password_confirmation" aria-label="Show password">
                    Show
                </button>
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            <p id="password-match" class="mt-2 text-sm text-gray-500" aria-live="polite">
                Enter the same password again.
            </p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        // Keep client-side guidance aligned with AppServiceProvider's server rules.
        const password = document.getElementById('password');
        const confirmation = document.getElementById('password_confirmation');

        document.querySelectorAll('[data-password-toggle]').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.passwordToggle);
                const showing = input.type === 'text';

                input.type = showing ? 'password' : 'text';
                button.textContent = showing ? 'Show' : 'Hide';
                button.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
            });
        });

        const updateRequirement = (id, valid, label) => {
            const element = document.getElementById(id);
            element.textContent = (valid ? '✓' : '○') + ' ' + label;
            element.classList.toggle('text-green-600', valid);
            element.classList.toggle('text-red-600', !valid && password.value.length > 0);
            element.classList.toggle('text-gray-500', !valid && password.value.length === 0);
        };

        const updatePasswordIndicators = () => {
            const value = password.value;
            updateRequirement('password-length', value.length >= 8, 'At least 8 characters');
            updateRequirement('password-case', /[a-z]/.test(value) && /[A-Z]/.test(value), 'Uppercase and lowercase letters');
            updateRequirement('password-number', /\d/.test(value), 'At least one number');

            const match = document.getElementById('password-match');
            const matches = confirmation.value.length > 0 && value === confirmation.value;
            match.textContent = confirmation.value.length === 0
                ? 'Enter the same password again.'
                : matches ? '✓ Passwords match.' : '✕ Passwords do not match.';
            match.classList.toggle('text-green-600', matches);
            match.classList.toggle('text-red-600', confirmation.value.length > 0 && !matches);
            match.classList.toggle('text-gray-500', confirmation.value.length === 0);
        };

        password.addEventListener('input', updatePasswordIndicators);
        confirmation.addEventListener('input', updatePasswordIndicators);
    </script>
</x-guest-layout>
