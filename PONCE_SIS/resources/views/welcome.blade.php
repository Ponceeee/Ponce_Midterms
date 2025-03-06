<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-blue-100 to-white">
            <!-- Navigation -->
            <nav class="bg-white/80 backdrop-blur-sm border-b border-gray-100 fixed w-full z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <a href="/" class="flex items-center">
                                <x-application-logo class="w-8 h-8 text-blue-600" />
                                <span class="ml-3 text-xl font-semibold text-gray-800">
                                    {{ config('app.name', 'Laravel') }}
                                </span>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="flex items-center space-x-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ route(auth()->user()->role === 'admin' ? 'admin-dashboard' : 'student-dashboard') }}"
                                        class="px-4 py-2 text-gray-700 hover:text-blue-600 transition">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="px-4 py-2 text-gray-700 hover:text-blue-600 transition">
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <div class="relative pt-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 leading-tight mb-6">
                                Welcome to Our <span class="text-blue-600">Student Information System</span>
                            </h1>
                            <p class="text-lg text-gray-600 mb-8">
                                Manage your academic journey with our comprehensive student information system. 
                                Access your records, track your progress, and stay connected with your institution.
                            </p>
                            <div class="flex gap-4">
                                @guest
                                    <a href="{{ route('register') }}"
                                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                        Get Started
                                    </a>
                                    <a href="{{ route('login') }}"
                                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                        Sign In
                                    </a>
                                @endguest
                            </div>
                        </div>
                        <div class="hidden lg:block">
                            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80"
                                alt="Students" class="rounded-lg shadow-xl">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="bg-white py-24">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Features & Benefits</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">
                            Our system provides everything you need to manage your academic life efficiently
                        </p>
                    </div>
                    
                    <div class="grid md:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-100">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Easy Registration</h3>
                            <p class="text-gray-600">Simple and straightforward registration process for new students</p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-100">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Track Progress</h3>
                            <p class="text-gray-600">Monitor your academic progress and achievements in real-time</p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-100">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Secure Access</h3>
                            <p class="text-gray-600">Your information is protected with advanced security measures</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="bg-gray-50 border-t border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="text-center text-gray-600">
                        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
                        <p class="mt-2">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
