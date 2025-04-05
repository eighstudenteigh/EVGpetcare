<x-guest-layout>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ old('email', request()->email) }}">

        <!-- Password -->
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" type="password" name="password" required autofocus />
        <x-input-error :messages="$errors->get('password')" />

        <!-- Confirm Password -->
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        <x-text-input id="password_confirmation" type="password" name="password_confirmation" required />
        <x-input-error :messages="$errors->get('password_confirmation')" />

        <x-primary-button class="mt-4">
            {{ __('Reset Password') }}
        </x-primary-button>
        
        <p class="text-sm text-center mt-4">
            <a href="{{ route('login') }}" class="text-orange-600 hover:underline">Back to login</a>
        </p>
        
    </form>
</x-guest-layout>
