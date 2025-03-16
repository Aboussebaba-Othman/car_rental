@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-yellow-400 p-6 text-center mb-8">
            <h2 class="text-3xl font-bold text-black">Create your personal account</h2>
        </div>

        <div class="flex">
            <!-- Left side - Image -->
            <div class="w-1/3">
                <img src="../../images/user-registration.webp" alt="User registration" class="w-full h-full object-cover">
            </div>

            <!-- Right side - Form -->
            <div class="w-2/3 bg-gray-50 p-6">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Personal Information section -->
                    <div>
                        <h3 class="text-lg font-bold text-center mb-6">Personal Information</h3>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-700">Nom *:</label>
                                <input id="firstName" type="text" name="firstName" value="{{ old('firstName') }}"  
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('firstName') border-red-500 @enderror">
                                @error('firstName')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="lastName" class="block text-sm font-medium text-gray-700">Prenom *:</label>
                                <input id="lastName" type="text" name="lastName" value="{{ old('lastName') }}"  
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('lastName') border-red-500 @enderror">
                                @error('lastName')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mt-4">
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email *:</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone:</label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('phone') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">Optional</p>
                                @error('phone')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div> 
                        </div>

                        <div class="grid grid-cols-2 gap-6 mt-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password *:</label>
                                <input id="password" type="password" name="password" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password *:</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <!-- Terms and consent checkboxes -->
                        <div class="mt-6 space-y-2">
                            <div class="flex items-start">
                                <input id="newsletter" type="checkbox" name="newsletter" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="newsletter" class="ml-2 block text-sm text-gray-700">
                                    I want to receive newsletters and updates
                                </label>
                            </div>
                            <div class="flex items-start">
                                <input id="terms" type="checkbox" name="terms" required class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <div class="ml-2">
                                    <label for="terms" class="block text-xs text-gray-700">
                                        I agree to the <a href="#" class="text-blue-600 hover:underline">Terms and Conditions</a> and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="flex justify-end mt-8">
                            <button type="submit" class="bg-green-600 text-white px-8 py-2 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Create my account
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Alternative options -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-bold text-blue-500 hover:text-blue-800">
                            Login
                        </a>
                    </p>
                    <p class="text-sm text-gray-600 mt-2">
                        Want to register as a company?
                        <a href="{{ route('register.company') }}" class="font-bold text-blue-500 hover:text-blue-800">
                            Register as Company
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection