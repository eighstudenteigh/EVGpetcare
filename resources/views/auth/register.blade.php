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
                <div class="mb-4">
                    <label class="text-gray-700 font-medium">Phone <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        name="phone" 
                        id="phone" 
                        value="{{ old('phone') }}" 
                        class="w-full p-2 border rounded @error('phone') border-red-500 @enderror"
                        placeholder="09xxxxxxxxx or +63xxxxxxxxxx"
                        required
                        oninput="adjustMaxLength(this);"
                    >
                    @error('phone') 
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                    @enderror
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
                        type="password" name="password" required placeholder="must be at least 8 characters" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm" 
                        type="password" name="password_confirmation" required required placeholder="must be at least 8 characters"/>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Register and Login Buttons -->
<div class="flex items-center justify-between mt-4">
    <a href="{{ route('login') }}" class="px-5 bg-blue-600 text-white font-bold py-2 rounded hover:bg-gray-700 transition-colors text-center">
        {{ __('Login') }}
    </a>
    
    <button type="submit" class="px-5 bg-orange-500 text-white font-bold py-2 rounded hover:bg-gray-600 transition-colors">
        {{ __('Register') }}
    </button>
</div>
            </form>
        </div>
        <script>
            function adjustMaxLength(input) {
                const value = input.value;
        
                // Allow only numbers and the plus sign at the beginning
                input.value = value.replace(/[^0-9+]/g, '');
        
                // Adjust max length dynamically
                if (value.startsWith('+63')) {
                    input.maxLength = 13; // +63 followed by 10 digits
                } else if (value.startsWith('09')) {
                    input.maxLength = 11; // 09 followed by 9 digits
                } else {
                    input.maxLength = 13; // Default max length (for unexpected formats)
                }
            }
        </script>
    </main>
</x-guest-layout>
