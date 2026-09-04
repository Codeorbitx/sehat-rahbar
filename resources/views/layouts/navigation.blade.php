<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left side: Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Sehat Rahbar" class="h-9 w-9 object-contain">
                    <span class="hidden sm:inline text-base font-bold text-navy-900" translate="no">{{ config('app.name', 'Sehat Rahbar') }}</span>
                </a>
            </div>

            <!-- Desktop Nav Links -->
            <div class="hidden sm:flex sm:items-center sm:gap-1">
                <a href="{{ route('dashboard') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-800' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                    {{ __('Dashboard') }}
                </a>
                <a href="{{ route('patients.index') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('patients.index') ? 'bg-brand-50 text-brand-800' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                    {{ __('Patients') }}
                </a>
                <a href="{{ route('patients.create') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('patients.create') ? 'bg-brand-50 text-brand-800' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                    {{ __('New Patient') }}
                </a>
            </div>

            <!-- Right side: User dropdown -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <!-- Quick action -->
                <a href="{{ route('patients.create') }}"
                   class="btn-success text-xs px-3 py-1.5 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('New Screening') }}
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 focus:outline-none transition px-2 py-1.5 rounded-lg hover:bg-gray-100">
                            <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-800 flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200 bg-white">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="block px-3 py-2.5 rounded-lg text-base font-medium transition
                      {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-800' : 'text-gray-700 hover:bg-gray-100' }}">
                {{ __('Dashboard') }}
            </a>
            <a href="{{ route('patients.index') }}"
               class="block px-3 py-2.5 rounded-lg text-base font-medium transition
                      {{ request()->routeIs('patients.index') ? 'bg-brand-50 text-brand-800' : 'text-gray-700 hover:bg-gray-100' }}">
                {{ __('Patients') }}
            </a>
            <a href="{{ route('patients.create') }}"
               class="block px-3 py-2.5 rounded-lg text-base font-medium transition
                      {{ request()->routeIs('patients.create') ? 'bg-brand-50 text-brand-800' : 'text-gray-700 hover:bg-gray-100' }}">
                {{ __('New Patient') }}
            </a>
            <a href="{{ route('patients.create') }}"
               class="block px-3 py-2.5 rounded-lg text-base font-medium transition text-health-700 hover:bg-health-50">
                + {{ __('New Screening') }}
            </a>
        </div>

        <div class="px-4 py-3 border-t border-gray-200">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-800 flex items-center justify-center text-sm font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-100 transition">
                {{ __('Profile') }}
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-start px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-100 transition">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</nav>
