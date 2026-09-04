<!DOCTYPE html>
<html lang="ur" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#064e3b">
    <link rel="manifest" href="/manifest.json">
    <title>{{ config('app.name', 'Sehat Rahbar') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-800">

    {{-- ── Top bar ── --}}
    <header class="bg-brand-900 border-b border-white/10 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-white.png') }}" alt="Sehat Rahbar" class="h-12 w-auto object-contain">
                <span class="text-base font-bold text-white" translate="no">{{ config('app.name', 'Sehat Rahbar') }}</span>
            </a>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-brand-800 shadow-sm transition-colors duration-200 hover:bg-brand-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-300">{{ __('Dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-white hover:text-brand-100 px-3 py-2 transition-colors duration-200">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-brand-800 shadow-sm transition-colors duration-200 hover:bg-brand-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-300">{{ __('Register') }}</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- ── Hero ── --}}
    <section class="bg-gradient-to-b from-brand-50 via-white to-white py-16 sm:py-24">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Sehat Rahbar" class="w-16 h-16 mx-auto mb-4 object-contain">
            <h1 class="text-3xl sm:text-4xl font-bold text-navy-900 leading-tight" translate="no">
                {{ config('app.name', 'Sehat Rahbar') }}
            </h1>
            <p class="mt-3 text-lg sm:text-xl text-brand-700 font-medium">
                {{ __('Tagline') }}
            </p>
            <p class="mt-6 text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                {{ __('Landing hero description') }}
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('register') }}" class="btn-primary text-base px-8 py-3 w-full sm:w-auto">
                    {{ __('Start Screening') }}
                </a>
                <a href="#how-it-works" class="btn-secondary text-base px-8 py-3 w-full sm:w-auto">
                    {{ __('Learn More') }}
                </a>
            </div>
        </div>
    </section>

    {{-- ── Problem ── --}}
    <section class="py-14 sm:py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-navy-900">{{ __('The Problem') }}</h2>
            <p class="mt-4 text-base sm:text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                {{ __('Problem description') }}
            </p>
        </div>
    </section>

    {{-- ── Our Solution ── --}}
    <section class="py-14 sm:py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-navy-900">{{ __('Our Solution') }}</h2>
            <p class="mt-4 text-base sm:text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                {{ __('Solution description') }}
            </p>
        </div>
    </section>

    {{-- ── How it works ── --}}
    <section id="how-it-works" class="py-14 sm:py-20 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4">
            <h2 class="text-2xl sm:text-3xl font-bold text-navy-900 text-center">{{ __('How It Works') }}</h2>

            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Step 1 --}}
                <div class="card p-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-brand-100 text-brand-800 flex items-center justify-center mx-auto text-xl font-bold">۱</div>
                    <h3 class="mt-4 text-base font-semibold text-gray-800">{{ __('Step 1') }}</h3>
                    <p class="mt-2 text-sm text-gray-500">{{ __('Step 1 desc') }}</p>
                </div>
                {{-- Step 2 --}}
                <div class="card p-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-brand-100 text-brand-800 flex items-center justify-center mx-auto text-xl font-bold">۲</div>
                    <h3 class="mt-4 text-base font-semibold text-gray-800">{{ __('Step 2') }}</h3>
                    <p class="mt-2 text-sm text-gray-500">{{ __('Step 2 desc') }}</p>
                </div>
                {{-- Step 3 --}}
                <div class="card p-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-brand-100 text-brand-800 flex items-center justify-center mx-auto text-xl font-bold">۳</div>
                    <h3 class="mt-4 text-base font-semibold text-gray-800">{{ __('Step 3') }}</h3>
                    <p class="mt-2 text-sm text-gray-500">{{ __('Step 3 desc') }}</p>
                </div>
                {{-- Step 4 --}}
                <div class="card p-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-brand-100 text-brand-800 flex items-center justify-center mx-auto text-xl font-bold">۴</div>
                    <h3 class="mt-4 text-base font-semibold text-gray-800">{{ __('Step 4') }}</h3>
                    <p class="mt-2 text-sm text-gray-500">{{ __('Step 4 desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Key Features ── --}}
    <section class="py-14 sm:py-20 bg-white">
        <div class="max-w-5xl mx-auto px-4">
            <h2 class="text-2xl sm:text-3xl font-bold text-navy-900 text-center">{{ __('Key Features') }}</h2>

            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="card p-6 flex gap-4 items-start">
                    <div class="w-10 h-10 rounded-lg bg-health-100 text-health-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">{{ __('Feature 1') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Feature 1 desc') }}</p>
                    </div>
                </div>
                <div class="card p-6 flex gap-4 items-start">
                    <div class="w-10 h-10 rounded-lg bg-brand-100 text-brand-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">{{ __('Feature 2') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Feature 2 desc') }}</p>
                    </div>
                </div>
                <div class="card p-6 flex gap-4 items-start">
                    <div class="w-10 h-10 rounded-lg bg-warn-100 text-warn-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">{{ __('Feature 3') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Feature 3 desc') }}</p>
                    </div>
                </div>
                <div class="card p-6 flex gap-4 items-start">
                    <div class="w-10 h-10 rounded-lg bg-health-100 text-health-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">{{ __('Feature 4') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Feature 4 desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Benefits for frontline health workers ── --}}
    <section class="py-14 sm:py-20 bg-brand-900 text-white">
        <div class="max-w-5xl mx-auto px-4">
            <h2 class="text-2xl sm:text-3xl font-bold text-center text-brand-100">{{ __('Benefits for Frontline Health Workers') }}</h2>

            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="flex gap-3 items-start bg-brand-800/50 rounded-xl p-5">
                    <svg class="w-6 h-6 text-health-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <p class="text-sm text-brand-100 leading-relaxed">{{ __('Benefit 1') }}</p>
                </div>
                <div class="flex gap-3 items-start bg-brand-800/50 rounded-xl p-5">
                    <svg class="w-6 h-6 text-health-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <p class="text-sm text-brand-100 leading-relaxed">{{ __('Benefit 2') }}</p>
                </div>
                <div class="flex gap-3 items-start bg-brand-800/50 rounded-xl p-5">
                    <svg class="w-6 h-6 text-health-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <p class="text-sm text-brand-100 leading-relaxed">{{ __('Benefit 3') }}</p>
                </div>
                <div class="flex gap-3 items-start bg-brand-800/50 rounded-xl p-5">
                    <svg class="w-6 h-6 text-health-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <p class="text-sm text-brand-100 leading-relaxed">{{ __('Benefit 4') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Secure patient records + Referral guidance ── --}}
    <section class="py-14 sm:py-20 bg-white">
        <div class="max-w-5xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="card p-8 text-center">
                    <div class="w-14 h-14 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">{{ __('Secure and Organized Patient Records') }}</h3>
                    <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                        {{ __('Feature 2 desc') }}
                    </p>
                </div>
                <div class="card p-8 text-center">
                    <div class="w-14 h-14 rounded-full bg-warn-100 text-warn-700 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">{{ __('Clear Referral and Urgency Guidance') }}</h3>
                    <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                        {{ __('Feature 3 desc') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CTA ── --}}
    <section class="py-14 sm:py-20 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-navy-900">{{ __('Start Screening') }}</h2>
            <p class="mt-3 text-base text-gray-600">
                {{ __('Landing hero description') }}
            </p>
            <a href="{{ route('register') }}" class="btn-primary text-base px-10 py-3 mt-8 inline-flex">
                {{ __('Start Screening') }}
            </a>
        </div>
    </section>

    {{-- ── Footer ── --}}
    <footer class="bg-brand-900 border-t border-white/10 py-6">
        <div class="max-w-6xl mx-auto px-4 text-center text-xs text-white/80">
            <p>&copy; {{ date('Y') }} <span translate="no" class="font-semibold text-white">{{ config('app.name', 'Sehat Rahbar') }}</span></p>
            <p class="mt-1">{{ __('This is a decision-support tool, not a diagnosis. Clinical judgment should always guide final decisions.') }}</p>
        </div>
    </footer>

</body>
</html>
