<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Enter the six-digit verification code sent to your email address, or use the verification link in that email.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.code') }}" class="mt-4">
        @csrf

        <x-input-label for="code" :value="__('Email verification code')" />
        <x-text-input id="code" class="block mt-1 w-full" type="text" name="code"
                      inputmode="numeric" pattern="[0-9]{6}" maxlength="6"
                      autocomplete="one-time-code" required autofocus />
        <x-input-error :messages="$errors->get('code')" class="mt-2" />

        <x-primary-button class="mt-3">
            {{ __('Verify email code') }}
        </x-primary-button>
    </form>

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
