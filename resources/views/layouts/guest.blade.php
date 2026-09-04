<!DOCTYPE html>
<html lang="ur" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#047857">
    <link rel="manifest" href="/manifest.json">
    <title>{{ config('app.name', 'Sehat Rahbar') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-b from-brand-50 to-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-sm">
            <!-- Logo & branding -->
            <div class="text-center mb-6">
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ asset('images/logo.png') }}" alt="Sehat Rahbar" class="w-14 h-14 mx-auto object-contain">
                </a>
                <h1 class="mt-2 text-xl font-bold text-navy-900" translate="no">{{ config('app.name', 'Sehat Rahbar') }}</h1>
                <p class="mt-1 text-xs text-gray-500">{{ __('Tagline') }}</p>
            </div>

            <!-- Card -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-200 overflow-hidden">
                <div class="p-6">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer link -->
            <p class="mt-4 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} <span translate="no">{{ config('app.name', 'Sehat Rahbar') }}</span>
            </p>
        </div>
    </div>
</body>
</html>
