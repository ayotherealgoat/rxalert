{{-- @props(['isOpen'])

<div x-show="isOpen" class="sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
        <x-nav-links href="{{ route('reminders.index') }}" :active="request()->routeIs('reminders.index')" class="block pl-3 pr-4 py-2">
            Dashboard
        </x-nav-links>
        <x-nav-links href="{{ route('reminders.create') }}" :active="request()->routeIs('reminders.create')" class="block pl-3 pr-4 py-2">
            Add Medication
        </x-nav-links>
    </div>
    <div class="pt-4 pb-3 border-t border-gray-200">
        <div class="flex items-center px-4">
            <div class="flex-shrink-0">
                <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                    <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
            </div>
            <div class="ml-3">
                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
            </div>
        </div>
        <div class="mt-3 space-y-1">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                    Sign out
                </button>
            </form>
        </div>
    </div>
</div>

Mobile menu has been moved to layout component --}}