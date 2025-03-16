<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Car Rental System') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="{{ route('home') }}" class="text-lg font-bold text-gray-800 hover:text-blue-600 transition duration-200">
                                Car Rental
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        @guest
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-blue-600 transition duration-200">Log in</a>
                            <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-blue-600 transition duration-200">Register</a>
                        @else
                            <div class="flex items-center">
                                <span class="text-gray-800 mr-3 font-semibold">{{ Auth::user()->username }}</span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-sm text-gray-700 hover:text-blue-600 transition duration-200">
                                        Log out
                                    </button>
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-6">
            @yield('content')
        </main>
    </div>
</body>
</html>