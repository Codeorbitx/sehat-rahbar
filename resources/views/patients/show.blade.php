<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto space-y-6">

                @php
                    $badges = [
                        'high' => ['label' => 'High Priority', 'badge' => 'bg-red-600', 'dot' => 'bg-red-500'],
                        'moderate' => ['label' => 'Moderate Priority', 'badge' => 'bg-yellow-500', 'dot' => 'bg-yellow-400'],
                        'low' => ['label' => 'Low Priority', 'badge' => 'bg-emerald-600', 'dot' => 'bg-emerald-500'],
                    ];
                    $fallback = ['label' => 'Pending', 'badge' => 'bg-gray-400', 'dot' => 'bg-gray-300'];
                    $statusStyles = [
                        'pending' => 'bg-yellow-500',
                        'referred' => 'bg-blue-500',
                        'completed' => 'bg-emerald-600',
                    ];
                @endphp

                @if (session('success'))
                    <div class="text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md px-3 py-2">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="text-sm text-red-700 bg-red-50 border border-red-300 rounded-md px-3 py-2">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Patient info --}}
                <div class="bg-white shadow-md rounded-xl border border-gray-100 overflow-hidden">
                    <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">
                                {{ $patient->name }}
                                @if ($patient->patient_code)
                                    <span class="inline-block ml-2 align-middle bg-gray-100 text-gray-600 text-xs font-mono font-medium px-2 py-0.5 rounded-md">{{ $patient->patient_code }}</span>
                                @endif
                            </h3>
                            <div class="mt-2 flex flex-wrap gap-x-6 gap-y-1 text-sm text-gray-600">
                                <p><span class="font-medium text-gray-700">Age:</span> {{ $patient->age ?? '—' }}</p>
                                <p><span class="font-medium text-gray-700">Gestational Age:</span> {{ $patient->gestational_age_weeks ? $patient->gestational_age_weeks.' weeks' : '—' }}</p>
                            </div>
                        </div>
                        <a href="{{ route('screenings.create', $patient) }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold rounded-md transition">
                            New Screening
                        </a>
                    </div>
                </div>

                {{-- Referrals --}}
                @if ($patient->referrals->isNotEmpty())
                    <div class="bg-white shadow-md rounded-xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-sm font-semibold text-gray-700">Referrals</h3>
                        </div>
                        <ul class="divide-y divide-gray-100">
                            @foreach ($patient->referrals as $referral)
                                <li class="px-6 py-4 flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $referral->facility_name }}</p>
                                        <p class="mt-0.5 text-xs text-gray-500">{{ $referral->referral_date?->format('M j, Y') ?? '—' }}</p>
                                    </div>
                                    <span class="inline-block {{ $statusStyles[$referral->status] ?? 'bg-gray-400' }} text-white text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full">
                                        {{ ucfirst($referral->status) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Screening history timeline --}}
                <div class="bg-white shadow-md rounded-xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700">Screening History</h3>
                    </div>

                    @if ($patient->screenings->isEmpty())
                        <div class="px-6 py-12 text-center">
                            <p class="text-sm text-gray-500">No screenings recorded yet.</p>
                            <a href="{{ route('screenings.create', $patient) }}"
                                class="mt-3 inline-block text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                                Start the first screening
                            </a>
                        </div>
                    @else
                        <ol class="relative border-l-2 border-gray-100 ml-4 py-6 pr-6 space-y-8">
                            @foreach ($patient->screenings as $screening)
                                @php
                                    $priority = $screening->triageResult->priority_level ?? null;
                                    $badge = $badges[$priority] ?? $fallback;
                                @endphp
                                <li class="relative pl-6">
                                    <span class="absolute -left-[9px] top-1 h-4 w-4 rounded-full ring-4 ring-white {{ $badge['dot'] }}"></span>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="text-sm font-semibold text-gray-800">{{ $screening->created_at->format('M j, Y, g:i A') }}</span>
                                        <span class="inline-block {{ $badge['badge'] }} text-white text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full">
                                            {{ $badge['label'] }}
                                        </span>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600">{{ $screening->triageResult->reasons ?? 'Result pending.' }}</p>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
