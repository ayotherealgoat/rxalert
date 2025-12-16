<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Medication Reminder') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <style>
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
    </style>
</head>

<body class="antialiased">
    <div class="min-h-screen pattern">
        <div x-data="{ isOpen: false }" class="relative min-h-screen">
            <!-- Navigation -->
            <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 fixed w-full z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <span class="text-2xl font-bold gradient-text">RxAlert</span>
                        </div>

                        <!-- Mobile menu button -->
                        <div class="flex items-center sm:hidden">
                            <button @click="isOpen = !isOpen" class="text-gray-500 hover:text-gray-600">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path x-show="!isOpen" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    <path x-show="isOpen" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Desktop menu -->
                        <div class="hidden sm:flex sm:items-center sm:space-x-8">
                            @auth
                                <a href="{{ route('reminders.index') }}"
                                    class="font-medium text-indigo-600 hover:text-indigo-500">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="font-medium text-gray-600 hover:text-gray-900">Log
                                    in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md">Get
                                        Started</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div x-show="isOpen" class="sm:hidden bg-white border-b border-gray-100">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        @auth
                            <a href="{{ route('reminders.index') }}"
                                class="block px-3 py-2 text-base font-medium text-indigo-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-600">Log
                                in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="block px-3 py-2 text-base font-medium text-gray-600">Register</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </nav>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Hero Section -->
                <div class="pt-32 pb-20">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div data-aos="fade-right">
                            <h1 class="text-5xl md:text-6xl font-extrabold mb-8">
                                Stay Healthy, Stay <span class="gradient-text">On Track</span>
                            </h1>
                            <p class="text-xl text-gray-600 mb-10">
                                Never miss a medication again. Our smart reminder system helps you maintain your health
                                journey with timely notifications and easy tracking.
                            </p>
                            <div class="space-x-4">
                                @auth
                                    <a href="{{ route('reminders.index') }}"
                                        class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                        Go to Dashboard
                                        <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                @else
                                    <a href="{{ route('register') }}"
                                        class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                        Get Started
                                        <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('login') }}"
                                        class="inline-flex items-center px-8 py-4 border border-gray-300 text-lg font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-all duration-300">
                                        Sign In
                                    </a>
                                @endauth
                            </div>
                            <!-- Stats -->
                            <div class="mt-12 grid grid-cols-3 gap-8">
                                <div>
                                    <p class="text-4xl font-bold gradient-text">99%</p>
                                    <p class="text-gray-600">Medication Adherence</p>
                                </div>
                                <div>
                                    <p class="text-4xl font-bold gradient-text">10k+</p>
                                    <p class="text-gray-600">Active Users</p>
                                </div>
                                <div>
                                    <p class="text-4xl font-bold gradient-text">24/7</p>
                                    <p class="text-gray-600">Support</p>
                                </div>
                            </div>
                        </div>
                        <div class="hidden lg:block" data-aos="fade-left">
                            <img src="{{ asset('images/medical-illustration.jpg') }}" alt="Medical Illustration"
                                class="w-full h-auto object-cover rounded-lg shadow-md">
                        </div>

                    </div>
                </div>

                <!-- Features Section -->
                <div class="py-16">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="relative group">
                            <div
                                class="float bg-white rounded-xl shadow-lg p-8 transition-all duration-300 hover:shadow-2xl">
                                <div class="text-indigo-600 mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold mb-2">Timely Reminders</h3>
                                <p class="text-gray-600">Never miss a dose with our smart reminder system that notifies
                                    you at the right time.</p>
                            </div>
                        </div>

                        <div class="relative group">
                            <div class="float bg-white rounded-xl shadow-lg p-8 transition-all duration-300 hover:shadow-2xl"
                                style="animation-delay: 0.2s">
                                <div class="text-indigo-600 mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold mb-2">Easy Management</h3>
                                <p class="text-gray-600">Manage your medications effortlessly with our intuitive
                                    dashboard and tracking system.</p>
                            </div>
                        </div>

                        <div class="relative group">
                            <div class="float bg-white rounded-xl shadow-lg p-8 transition-all duration-300 hover:shadow-2xl"
                                style="animation-delay: 0.4s">
                                <div class="text-indigo-600 mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold mb-2">Health Tracking</h3>
                                <p class="text-gray-600">Monitor your medication adherence and track your health
                                    progress over time.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonials -->
                {{-- <div class="py-16 bg-white/50 rounded-2xl my-16">
                    <h2 class="text-3xl font-bold text-center mb-12">What Our Users Say</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="bg-white p-6 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="100">
                            <div class="flex items-center mb-4">
                                <div
                                    class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                    JD</div>
                                <div class="ml-4">
                                    <h4 class="font-semibold">John Doe</h4>
                                    <div class="flex text-yellow-400">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600">"This app has been a lifesaver! I never forget my medications
                                anymore."</p>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
                            <div class="flex items-center mb-4">
                                <div
                                    class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                    AS</div>
                                <div class="ml-4">
                                    <h4 class="font-semibold">Alice Smith</h4>
                                    <div class="flex text-yellow-400">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600">"Simple to use and very reliable. The reminders are always on
                                time!"</p>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="300">
                            <div class="flex items-center mb-4">
                                <div
                                    class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                    RJ</div>
                                <div class="ml-4">
                                    <h4 class="font-semibold">Robert Johnson</h4>
                                    <div class="flex text-yellow-400">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600">"Great app for managing multiple medications. The interface is very
                                intuitive."</p>
                        </div>
                    </div>
                </div> --}}

                <!-- FAQ Section -->
                {{-- <div class="py-16" x-data="{ selected: null }">
                    <h2 class="text-3xl font-bold text-center mb-12">Frequently Asked Questions</h2>
                    <div class="space-y-4">
                        <div class="bg-white rounded-lg shadow-md">
                            <button @click="selected !== 1 ? selected = 1 : selected = null"
                                class="flex justify-between items-center w-full p-4 focus:outline-none">
                                <span class="font-medium">How do the reminders work?</span>
                                <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': selected === 1 }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="selected === 1" class="p-4 pt-0">
                                <p class="text-gray-600">We send timely notifications through email when it's time to
                                    take your medication. You can set up multiple reminders for different medications
                                    and customize the schedule according to your needs.</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-md">
                            <button @click="selected !== 2 ? selected = 2 : selected = null"
                                class="flex justify-between items-center w-full p-4 focus:outline-none">
                                <span class="font-medium">Is my medical information secure?</span>
                                <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': selected === 2 }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="selected === 2" class="p-4 pt-0">
                                <p class="text-gray-600">Yes, we take security very seriously. All your data is
                                    encrypted and stored securely. We comply with healthcare privacy standards to
                                    protect your information.</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-md">
                            <button @click="selected !== 3 ? selected = 3 : selected = null"
                                class="flex justify-between items-center w-full p-4 focus:outline-none">
                                <span class="font-medium">Can I track multiple medications?</span>
                                <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': selected === 3 }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="selected === 3" class="p-4 pt-0">
                                <p class="text-gray-600">Yes, you can manage multiple medications with different
                                    schedules. Our system helps you organize and track all your medications efficiently.
                                </p>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <!-- Footer -->
                <div class="border-t border-gray-200 py-8 mt-20">
                    <div class="text-center text-gray-500">
                        <p>&copy; {{ date('Y') }} MedRemind. All rights reserved.</p>
                        <div class="flex justify-center space-x-6 mt-4">
                            <a href="#" class="text-gray-400 hover:text-gray-500">Privacy Policy</a>
                            <a href="#" class="text-gray-400 hover:text-gray-500">Terms of Service</a>
                            <a href="#" class="text-gray-400 hover:text-gray-500">Contact</a>
                        </div>
                    </div>
                </div>
            </div>
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