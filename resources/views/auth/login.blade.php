<x-guest-layout>
    <div class="flex bg-gray-100 items-center justify-center p-4">

        <div class="w-full sm:max-w-md bg-white rounded-lg shadow-lg p-6">
           

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                    <x-text-input 
                        id="email"
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-transparent"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                    <x-text-input 
                        id="password"
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-transparent"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-4">
                    

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-orange-600 hover:underline">
                            Forgot password??
                        </a>
                    @endif
                </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <x-primary-button class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-gray-600 transition-colors">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
            </form>
        </div>
    </div>
</x-guest-layout>
