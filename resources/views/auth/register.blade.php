<x-guest-layout>
    <!-- Centered Container from Layout -->
    <main class="flex-grow flex items-center justify-center bg-gray-100">
        <div class="w-full sm:max-w-md bg-white rounded-lg shadow-lg p-8 mx-4 my-8">

            <!-- Form Title -->
            <h2 class="text-2xl font-semibold text-center text-orange-600 mb-6">Create an Account</h2>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" 
                        type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" 
                        type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone" :value="__('Phone (09xxxxxxxxx or +63xxxxxxxxxx)')" />
                    <x-text-input id="phone" class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" 
                        type="text" name="phone" :value="old('phone')" required pattern="^(09|\+63)\d{9}$" title="Must be 10 or 11 digits starting with 09 or +63" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Address -->
                <div>
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" 
                        type="text" name="address" :value="old('address')" required />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" 
                        type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" 
                        type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Register Button -->
                <div class="flex items-center justify-between mt-4">
                    <a class="text-sm text-gray-600 hover:text-orange-600" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                    <x-primary-button class="bg-orange-600 hover:bg-orange-700 focus:ring-orange-500">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </main>
</x-guest-layout>
