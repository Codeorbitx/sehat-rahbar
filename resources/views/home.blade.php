<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#047857">
    <link rel="manifest" href="/manifest.json">
    <title>{{ config('app.name', 'Sehat Rahbar') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-md bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="flex flex-col items-center text-center pt-10 pb-8 px-8">
                <img src="{{ asset('images/logo.png') }}" alt="Sehat Rahbar" class="w-16 h-auto object-contain">

                <h1 class="mt-4 text-2xl font-bold text-gray-800">{{ config('app.name', 'Sehat Rahbar') }}</h1>

                <p class="mt-2 text-sm font-medium text-emerald-700">
                    AI-powered maternal health support for frontline health workers
                </p>

                <p class="mt-4 text-sm text-gray-600 leading-relaxed">
                    Sehat Rahbar helps frontline health workers screen expectant mothers, triage risk instantly, and refer high-risk patients for timely care.
                </p>

                <a href="{{ route('login') }}"
                    class="mt-6 w-full inline-flex justify-center py-2 px-4 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold rounded-md transition">
                    Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>
