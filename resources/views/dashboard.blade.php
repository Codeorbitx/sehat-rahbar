<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-navy-900">{{ __('Dashboard') }}</h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <p class="text-gray-600">{{ __("You're logged in!") }}</p>
        <a href="{{ route('dashboard.summary') }}" class="btn-primary mt-4 inline-flex">
            {{ __('Dashboard Summary') }}
        </a>
    </div>
</x-app-layout>
