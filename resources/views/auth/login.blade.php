@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 to-blue-100 py-12 px-4 sm:px-6 lg:px-8 transition-all duration-300">
    <div class="max-w-md w-full space-y-8 transform transition-all duration-500 opacity-0 translate-y-4" id="login-container">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden transform transition-all duration-500 hover:shadow-2xl">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2"></div>

            <div class="p-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Welcome Back</h2>
                    <p class="text-sm text-gray-600 mb-8">Sign in to your account to continue</p>
                </div>

                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6" id="login-form">
                    @csrf
                    
                    @foreach(['email' => 'Email', 'password' => 'Password'] as $field => $label)
                        <div class="relative">
                            <div class="form-floating">
                                <input id="{{ $field }}" type="{{ $field == 'password' ? 'password' : 'email' }}" name="{{ $field }}" required
                                    class="peer h-12 w-full border-b-2 border-gray-300 text-gray-900 placeholder-transparent focus:outline-none focus:border-indigo-600 transition-all duration-300 @error($field) border-red-500 @enderror"
                                    placeholder="{{ $label }}">
                                <label for="{{ $field }}" class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">
                                    {{ $label }}
                                </label>
                            </div>
                            @error($field)
                                <p class="text-red-500 text-xs mt-1 transform transition-all duration-300 animate-pulse">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach

                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition-all duration-200 cursor-pointer">
                            <label for="remember" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                                Remember Me
                            </label>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                            Forgot Password?
                        </a>
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            Sign in
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Don't have an account?</span>
                        </div>
                    </div>
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <a href="{{ route('register') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200 hover:text-indigo-600 hover:border-indigo-600">
                            Register as User
                        </a>
                        <a href="{{ route('register.company') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200 hover:text-indigo-600 hover:border-indigo-600">
                            Register as Company
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('login-container');
        setTimeout(() => { container.classList.remove('opacity-0', 'translate-y-4'); }, 100);
    });
</script>
@endsection