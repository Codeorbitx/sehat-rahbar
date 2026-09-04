@php
    $user = Auth::user();

    // Two-letter initials (e.g. "Laiba Gul" -> "LG"), UTF-8 safe for Urdu names.
    $nameParts = preg_split('/\s+/u', trim((string) $user->name)) ?: [];
    $initials = mb_strtoupper(
        mb_substr($nameParts[0] ?? '', 0, 1, 'UTF-8').
        ($nameParts[1] ?? '' ? mb_substr($nameParts[1], 0, 1, 'UTF-8') : ''),
        'UTF-8'
    );

    $locale = app()->getLocale();

    // Active-state detection shared by the desktop links and the mobile panel.
    $isDashboard  = request()->routeIs('dashboard*');
    $isPatients   = request()->routeIs('patients.index', 'patients.show', 'screenings.*', 'referrals.*');
    $isNewPatient = request()->routeIs('patients.create');

    // Shared class strings (kept identical across desktop/mobile for consistency).
    $navLink  = 'inline-flex items-center gap-1.5 border-b-2 px-3 text-sm font-medium transition-colors duration-200';
    $navActive = 'border-brand-300 text-white';
    $navIdle   = 'border-transparent text-brand-100 hover:border-brand-400 hover:text-white';

    $menuItem = 'flex w-full items-center gap-2.5 px-4 py-2 text-start text-sm font-medium text-gray-700 transition-colors duration-150 hover:bg-brand-50 hover:text-brand-800';

    $mobileLink = 'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors duration-150';
@endphp

<div x-data="{ open: false, scrolled: false }"
     x-init="scrolled = window.pageYOffset > 4"
     @scroll.window.passive="scrolled = window.pageYOffset > 4"
     @keydown.escape.window="open = false"
     x-effect="document.body.style.overflow = open ? 'hidden' : ''">

    <nav class="sticky top-0 z-50 border-b border-white/10 bg-brand-900 transition-[background-color,box-shadow,backdrop-filter] duration-300"
         :class="scrolled ? 'bg-brand-900/90 shadow-lg shadow-brand-950/30 backdrop-blur-md' : ''">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-3 py-2 md:py-2.5">

                <!-- Left: brand + primary navigation -->
                <div class="flex min-w-0 items-center gap-7">
                    <a href="{{ route('dashboard') }}" class="flex shrink-0 items-center gap-4" aria-label="{{ config('app.name', 'Sehat Rahbar') }}">
                        <img src="{{ asset('images/logo-white.png') }}" alt="{{ config('app.name', 'Sehat Rahbar') }}" class="h-14 w-auto object-contain md:h-16">
                        <span class="-mt-2 hidden text-lg font-bold leading-none text-white sm:block md:text-xl" translate="no">{{ config('app.name', 'Sehat Rahbar') }}</span>
                    </a>

                    <!-- Desktop nav links -->
                    <div class="hidden items-stretch self-stretch lg:flex">
                        <a href="{{ route('dashboard') }}" class="{{ $navLink }} {{ $isDashboard ? $navActive : $navIdle }}">
                            <x-icon name="dashboard" class="h-4 w-4 shrink-0"/>
                            {{ __('Dashboard') }}
                        </a>
                        <a href="{{ route('patients.index') }}" class="{{ $navLink }} {{ $isPatients ? $navActive : $navIdle }}">
                            <x-icon name="users" class="h-4 w-4 shrink-0"/>
                            {{ __('Patients') }}
                        </a>
                        <a href="{{ route('patients.create') }}" class="{{ $navLink }} {{ $isNewPatient ? $navActive : $navIdle }}">
                            <x-icon name="user-plus" class="h-4 w-4 shrink-0"/>
                            {{ __('New Patient') }}
                        </a>
                    </div>
                </div>

                <!-- Right: quick action + user menu + hamburger -->
                <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                    <!-- New screening (desktop / tablet) -->
                    <a href="{{ route('patients.create') }}" title="{{ __('New Screening') }}"
                       class="hidden items-center gap-1.5 rounded-lg bg-white px-3.5 py-2 text-sm font-semibold text-brand-800 shadow-sm transition-colors duration-200 hover:bg-brand-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-300 sm:inline-flex">
                        <x-icon name="plus" class="h-4 w-4"/>
                        <span>{{ __('New Screening') }}</span>
                    </a>

                    <!-- New screening — icon-only on very small screens -->
                    <a href="{{ route('patients.create') }}" title="{{ __('New Screening') }}" aria-label="{{ __('New Screening') }}"
                       class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white text-brand-800 shadow-sm transition-colors duration-200 hover:bg-brand-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-300 sm:hidden">
                        <x-icon name="plus" class="h-4 w-4"/>
                    </a>

                    <!-- User dropdown -->
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button type="button" aria-haspopup="menu"
                                    class="flex items-center gap-2.5 rounded-full p-1 pe-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-300">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-800">{{ $initials }}</span>
                                <span class="hidden max-w-[10rem] truncate md:block">{{ $user->name }}</span>
                                <x-icon name="chevron-down" class="hidden h-4 w-4 text-brand-200 md:block"/>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Signed-in user -->
                            <div class="flex items-center gap-3 border-b border-gray-100 px-4 py-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-100 text-sm font-bold text-brand-800">{{ $initials }}</span>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                                    <p class="truncate text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="py-1.5">
                                <a href="{{ route('profile.edit') }}" class="{{ $menuItem }}">
                                    <x-icon name="user" class="h-4 w-4 shrink-0 text-gray-400"/>
                                    {{ __('My Profile') }}
                                </a>
                                <a href="{{ route('profile.edit') }}#settings" class="{{ $menuItem }}">
                                    <x-icon name="settings" class="h-4 w-4 shrink-0 text-gray-400"/>
                                    {{ __('Settings') }}
                                </a>
                            </div>

                            <!-- Language switch -->
                            <div class="border-t border-gray-100 py-1.5">
                                <p class="px-4 pb-1 pt-1.5 text-[11px] font-semibold uppercase tracking-wider text-gray-400">{{ __('Language') }}</p>
                                <a href="{{ route('locale.switch', 'ur') }}" class="{{ $menuItem }} justify-between">
                                    <span class="flex items-center gap-2.5">
                                        <x-icon name="languages" class="h-4 w-4 shrink-0 text-gray-400"/>
                                        <span translate="no">اردو</span>
                                    </span>
                                    @if ($locale === 'ur')
                                        <x-icon name="check" class="h-4 w-4 text-brand-700"/>
                                    @endif
                                </a>
                                <a href="{{ route('locale.switch', 'en') }}" class="{{ $menuItem }} justify-between">
                                    <span class="flex items-center gap-2.5">
                                        <x-icon name="languages" class="h-4 w-4 shrink-0 text-gray-400"/>
                                        <span translate="no">English</span>
                                    </span>
                                    @if ($locale === 'en')
                                        <x-icon name="check" class="h-4 w-4 text-brand-700"/>
                                    @endif
                                </a>
                            </div>

                            <!-- Logout -->
                            <div class="border-t border-gray-100 py-1.5">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex w-full items-center gap-2.5 px-4 py-2 text-start text-sm font-medium text-danger-600 transition-colors duration-150 hover:bg-danger-50 hover:text-danger-700">
                                        <x-icon name="logout" class="h-4 w-4 shrink-0"/>
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>

                    <!-- Hamburger (mobile / tablet) -->
                    <button type="button" @click="open = true" :aria-expanded="open ? 'true' : 'false'" aria-label="{{ __('Menu') }}"
                            class="rounded-lg p-2 text-brand-100 transition-colors duration-200 hover:bg-white/10 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-300 lg:hidden">
                        <x-icon name="menu" class="h-6 w-6"/>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile menu: backdrop -->
    <div x-cloak x-show="open" x-transition.opacity.duration.200ms
         class="fixed inset-0 z-[55] bg-gray-900/40 lg:hidden" aria-hidden="true"
         @click="open = false"></div>

    <!-- Mobile menu: slide-in panel -->
    <aside x-cloak x-show="open"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="ltr:translate-x-full rtl:-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="ltr:translate-x-full rtl:-translate-x-full"
           class="fixed inset-y-0 end-0 z-[56] flex w-72 max-w-[85vw] flex-col bg-white shadow-2xl lg:hidden"
           role="dialog" aria-modal="true" aria-label="{{ __('Menu') }}">

        <!-- Panel header -->
        <div class="flex h-16 shrink-0 items-center justify-between border-b border-gray-100 px-4">
            <a href="{{ route('dashboard') }}" @click="open = false" class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Sehat Rahbar') }}" class="h-9 w-9 object-contain">
                <span class="text-sm font-bold leading-none text-navy-900" translate="no">{{ config('app.name', 'Sehat Rahbar') }}</span>
            </a>
            <button type="button" @click="open = false" aria-label="{{ __('Close menu') }}"
                    class="rounded-lg p-2 text-gray-500 transition-colors duration-200 hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500">
                <x-icon name="close" class="h-5 w-5"/>
            </button>
        </div>

        <!-- Panel body -->
        <div class="flex-1 overflow-y-auto px-3 py-4">
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" @click="open = false"
                   class="{{ $mobileLink }} {{ $isDashboard ? 'bg-brand-50 text-brand-800' : 'text-gray-700 hover:bg-gray-100' }}">
                    <x-icon name="dashboard" class="h-5 w-5 shrink-0"/>
                    {{ __('Dashboard') }}
                </a>
                <a href="{{ route('patients.index') }}" @click="open = false"
                   class="{{ $mobileLink }} {{ $isPatients ? 'bg-brand-50 text-brand-800' : 'text-gray-700 hover:bg-gray-100' }}">
                    <x-icon name="users" class="h-5 w-5 shrink-0"/>
                    {{ __('Patients') }}
                </a>
                <a href="{{ route('patients.create') }}" @click="open = false"
                   class="{{ $mobileLink }} {{ $isNewPatient ? 'bg-brand-50 text-brand-800' : 'text-gray-700 hover:bg-gray-100' }}">
                    <x-icon name="user-plus" class="h-5 w-5 shrink-0"/>
                    {{ __('New Patient') }}
                </a>
            </div>

            <a href="{{ route('patients.create') }}" @click="open = false"
               class="mt-4 flex items-center justify-center gap-2 rounded-lg bg-health-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors duration-200 hover:bg-health-800">
                <x-icon name="plus" class="h-4 w-4"/>
                {{ __('New Screening') }}
            </a>

            <div class="mt-5 space-y-1 border-t border-gray-100 pt-4">
                <a href="{{ route('profile.edit') }}" @click="open = false"
                   class="{{ $mobileLink }} {{ request()->routeIs('profile.edit') ? 'bg-brand-50 text-brand-800' : 'text-gray-700 hover:bg-gray-100' }}">
                    <x-icon name="user" class="h-5 w-5 shrink-0"/>
                    {{ __('My Profile') }}
                </a>
                <a href="{{ route('profile.edit') }}#settings" @click="open = false"
                   class="{{ $mobileLink }} text-gray-700 hover:bg-gray-100">
                    <x-icon name="settings" class="h-5 w-5 shrink-0"/>
                    {{ __('Settings') }}
                </a>
            </div>

            <div class="mt-5 border-t border-gray-100 pt-4">
                <p class="px-3 pb-1 text-[11px] font-semibold uppercase tracking-wider text-gray-400">{{ __('Language') }}</p>
                <a href="{{ route('locale.switch', 'ur') }}" @click="open = false"
                   class="{{ $mobileLink }} justify-between {{ $locale === 'ur' ? 'bg-brand-50 text-brand-800' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="flex items-center gap-3">
                        <x-icon name="languages" class="h-5 w-5 shrink-0"/>
                        <span translate="no">اردو</span>
                    </span>
                    @if ($locale === 'ur')
                        <x-icon name="check" class="h-4 w-4"/>
                    @endif
                </a>
                <a href="{{ route('locale.switch', 'en') }}" @click="open = false"
                   class="{{ $mobileLink }} justify-between {{ $locale === 'en' ? 'bg-brand-50 text-brand-800' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="flex items-center gap-3">
                        <x-icon name="languages" class="h-5 w-5 shrink-0"/>
                        <span translate="no">English</span>
                    </span>
                    @if ($locale === 'en')
                        <x-icon name="check" class="h-4 w-4"/>
                    @endif
                </a>
            </div>
        </div>

        <!-- Panel footer: user + logout -->
        <div class="shrink-0 border-t border-gray-100 px-3 py-4">
            <div class="mb-3 flex items-center gap-3 px-1">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-800">{{ $initials }}</span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                    <p class="truncate text-xs text-gray-500">{{ $user->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-lg border border-danger-200 px-4 py-2.5 text-sm font-semibold text-danger-600 transition-colors duration-200 hover:bg-danger-50">
                    <x-icon name="logout" class="h-4 w-4"/>
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </aside>
</div>
