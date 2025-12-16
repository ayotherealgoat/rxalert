<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'RxAlert' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .float {
            animation: float 6s ease-in-out infinite;
        }

        .pattern {
            background-color: #f8fafc;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54.627 0l.83.828-1.415 1.415L51.8 0h2.827zM5.373 0l-.83.828L5.96 2.243 8.2 0H5.374zM48.97 0l3.657 3.657-1.414 1.414L46.143 0h2.828zM11.03 0L7.372 3.657 8.787 5.07 13.857 0H11.03zm32.284 0L49.8 6.485 48.384 7.9l-7.9-7.9h2.83zM16.686 0L10.2 6.485 11.616 7.9l7.9-7.9h-2.83zM22.344 0L13.858 8.485 15.272 9.9l9.9-9.9h-2.828zM32 0l-3.657 3.657 1.414 1.414L35.143 0H32zm-6.485 0L20.03 5.485 21.444 6.9l6.9-6.9h-2.83zm12.97 0l5.485 5.485-1.414 1.415-7.9-7.9h2.828zm13.43 0l-6.485 6.485 1.414 1.415 7.9-7.9h-2.828zm-9.9 0l3.657 3.657-1.414 1.414L35.143 0h2.828z' fill='%236366f1' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }

        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes glow {

            0%,
            100% {
                opacity: 0.5;
                transform: scale(1);
            }

            50% {
                opacity: 0.7;
                transform: scale(1.1);
            }
        }

        .animate-glow {
            animation: glow 2s ease-in-out infinite;
        }
    </style>
</head>

<body class="h-full antialiased">
    <div class="min-h-full">
        <nav x-data="{ isOpen: false }" class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-2xl font-bold text-indigo-600">RxAlert</span>
                        </div>
                        <!-- Desktop menu -->
                        @auth
                            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                                <x-nav-links href="{{ route('reminders.index') }}"
                                    :active="request()->routeIs('reminders.index')">
                                    Dashboard
                                </x-nav-links>
                                <x-nav-links href="{{ route('reminders.create') }}"
                                    :active="request()->routeIs('reminders.create')">
                                    Add Medication
                                </x-nav-links>
                                {{-- <x-nav-links href="{{ route('medications.index') }}"
                                    :active="request()->routeIs('medications.index')">
                                    Previous Medications
                                </x-nav-links> --}}
                            </div>
                        @endauth
                    </div>
                    <!-- Mobile menu button -->
                    <div class="sm:hidden">
                        <button @click="isOpen = !isOpen" type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                            :aria-expanded="isOpen">
                            <span class="sr-only">Open main menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!isOpen">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="isOpen">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <x-mobile-menu :isOpen="true" />
                    <div class="flex items-center">
                        {{-- <div class="flex-shrink-0">
                            <a href="{{ route('reminders.create') }}"
                                class="relative inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-700">
                                New Reminder
                            </a>
                        </div> --}}
                        <div class="hidden md:ml-4 md:flex-shrink-0 md:flex md:items-center">
                            <!-- Notification bell with counter -->
                            <button type="button"
                                class="relative p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">View notifications</span>
                                {{-- <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg> --}}
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span
                                    class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
                            </button>

                            <!-- Profile dropdown -->
                            {{-- <div class="ml-3 relative">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center">
                                        <span
                                            class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center">
                                            <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name,
                                                0, 1) }}</span>
                                        </span>
                                        <span class="ml-3 text-gray-900">{{ Auth::user()->name }}</span>
                                    </div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div> --}}
                            <div class="ml-3 relative">
                                @auth
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center">
                                            <span
                                                class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center">
                                                <span
                                                    class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                            </span>
                                            <span class="ml-3 text-gray-900">{{ Auth::user()->name }}</span>
                                        </div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Sign out
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-4">
                                        <a href="{{ route('login') }}"
                                            class="text-sm font-medium text-gray-500 hover:text-gray-700">Sign in</a>
                                        <a href="{{ route('register') }}"
                                            class="text-sm font-medium text-gray-500 hover:text-gray-700">Register</a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="py-10">
            <header>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold leading-tight text-gray-900">
                        {{ $heading ?? 'Dashboard' }}
                    </h1>
                </div>
            </header>
            <main>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="px-4 py-8 sm:px-0">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });
        });
    </script>
</body>

</html>