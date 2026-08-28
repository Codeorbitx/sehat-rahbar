<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sehat Rahbar') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-[300px] bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="flex flex-col items-center pt-8 pb-4 px-6">
                <img src="{{ asset('images/logo.png') }}" alt="Sehat Rahbar" class="w-14 h-auto object-contain">
            </div>
            <div class="px-6 pb-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>