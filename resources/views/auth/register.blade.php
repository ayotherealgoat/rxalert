<x-auth-layout title="Register">
    <h2 class="text-3xl font-bold text-center mb-8 gradient-text">Create Account</h2>

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf

        <div class="space-y-6">
            <div class="relative">
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                    class="peer w-full px-4 py-3 rounded-lg border-2 border-gray-200 placeholder-transparent focus:outline-none focus:border-indigo-600 transition-colors @error('name') border-red-500 @enderror"
                    placeholder="Name">
                <label for="name"
                    class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">
                    Full Name
                </label>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="peer w-full px-4 py-3 rounded-lg border-2 border-gray-200 placeholder-transparent focus:outline-none focus:border-indigo-600 transition-colors @error('email') border-red-500 @enderror"
                    placeholder="Email">
                <label for="email"
                    class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">
                    Email address
                </label>
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <input type="password" id="password" name="password" required
                    class="peer w-full px-4 py-3 rounded-lg border-2 border-gray-200 placeholder-transparent focus:outline-none focus:border-indigo-600 transition-colors @error('password') border-red-500 @enderror"
                    placeholder="Password">
                <label for="password"
                    class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">
                    Password
                </label>
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="peer w-full px-4 py-3 rounded-lg border-2 border-gray-200 placeholder-transparent focus:outline-none focus:border-indigo-600 transition-colors"
                    placeholder="Confirm Password">
                <label for="password_confirmation"
                    class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3.5 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">
                    Confirm Password
                </label>
            </div>

            <div class="flex items-center justify-center pt-2">
                <button type="submit"
                    class="w-full sm:w-auto px-8 py-3 text-white bg-gradient-to-r from-indigo-600 to-indigo-500 rounded-lg font-semibold shadow-lg hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-300">
                    Create Account
                </button>
            </div>

            <div class="text-center pt-4">
                <span class="text-gray-600">Already have an account?</span>
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 font-semibold ml-1">
                    Sign in here
                </a>
            </div>

            {{-- <div class="flex items-center justify-center pt-2">
                <button type="submit"
                    class="w-full sm:w-auto px-8 py-3 text-white bg-gradient-to-r from-indigo-600 to-indigo-500 rounded-lg font-semibold shadow-lg hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-300">
                    Create Account
                </button>
            </div> --}}
        </div>
    </form>
    </div>
    </div>
    </x-layout>