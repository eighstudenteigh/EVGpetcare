<x-guest-layout>
    <div class="flex bg-gray-100 items-center justify-center p-8 min-h-screen">
        <div class="w-full sm:max-w-md bg-white rounded-lg shadow-lg p-6">

            <h2 class="text-xl font-bold text-center text-orange-600 mb-4">Reset Your Password</h2>

            <p class="mb-4 text-sm text-gray-600">
                Forgot your password? Enter your email and we’ll send a link to reset it.
            </p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.custom.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input id="email" name="email" type="email"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-600 focus:outline-none"
                        required autofocus />
                    @error('email')
                        <p class="text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-orange-600 text-white py-2 rounded-lg hover:bg-orange-700 transition duration-200">
                        Email Password Reset Link
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:underline">Back to login</a>
            </div>
        </div>
    </div>
</x-guest-layout>
