<!DOCTYPE html>
<html lang="ur" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#047857">
        <link rel="manifest" href="/manifest.json">

        <title>{{ config('app.name', 'Sehat Rahbar') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800">
        <!-- Offline detection banner -->
        <div x-data="{ online: navigator.onLine }"
            @online.window="online = true"
            @offline.window="online = false"
            x-show="!online"
            x-cloak
            role="status"
            class="fixed inset-x-0 top-0 z-[60] bg-warn-100 border-b border-warn-300 text-warn-700 text-sm text-center py-2 px-4 font-medium">
            {{ __("You're offline — some features may not work.") }}
        </div>

        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-b border-gray-200">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-gray-400">
                    <span translate="no">{{ config('app.name', 'Sehat Rahbar') }}</span> &mdash; {{ __('This is a decision-support tool, not a diagnosis. Clinical judgment should always guide final decisions.') }}
                </div>
            </footer>
        </div>
    </body>
</html>
