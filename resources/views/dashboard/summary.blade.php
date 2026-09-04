<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-navy-900">
                    {{ __('Welcome') }}، {{ Auth::user()->name }}
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ __('Healthcare Operations Dashboard') }}</p>
            </div>
            <a href="{{ route('patients.create') }}" class="btn-success text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                {{ __('New Screening') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        {{-- ── Stat cards ── --}}
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <div class="stat-card">
                <p class="stat-card-label">{{ __('Total Patients') }}</p>
                <p class="stat-card-value text-brand-800">{{ $totalPatients }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-card-label">{{ __('Total Screenings') }}</p>
                <p class="stat-card-value text-navy-900">{{ $totalScreenings }}</p>
                <p class="text-xs text-gray-400">{{ $todaysScreenings }} {{ __('today') }}</p>
            </div>
            <div class="stat-card border-r-4 border-r-danger-400">
                <p class="stat-card-label">{{ __('High Priority') }}</p>
                <p class="stat-card-value text-danger-600">{{ $highCount }}</p>
            </div>
            <div class="stat-card border-r-4 border-r-health-500">
                <p class="stat-card-label">{{ __('Referred Patients') }}</p>
                <p class="stat-card-value text-health-700">{{ $referredCount }}</p>
            </div>
        </div>

        {{-- ── Two-column: Recent screenings + Recent patients ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Recent Screenings --}}
            <div class="card">
                <div class="card-header flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700">{{ __('Recent Screenings') }}</h3>
                </div>
                @if ($recentScreenings->isEmpty())
                    <div class="empty-state">
                        <p class="empty-state-text">{{ __('No screenings yet.') }}</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach ($recentScreenings as $screening)
                            @php
                                $priority = $screening->triageResult->priority_level ?? null;
                                $badgeClass = $priority === 'high' ? 'badge-high' : ($priority === 'moderate' ? 'badge-moderate' : 'badge-low');
                                $badgeLabel = $priority === 'high' ? __('High Priority') : ($priority === 'moderate' ? __('Moderate Priority') : __('Low Priority'));
                            @endphp
                            <li class="px-5 py-3 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <a href="{{ route('patients.show', $screening->patient) }}" class="text-sm font-medium text-gray-800 hover:text-brand-700 truncate block">
                                        {{ $screening->patient->name }}
                                    </a>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $screening->created_at->diffForHumans() }}</p>
                                </div>
                                @if ($priority)
                                    <span class="{{ $badgeClass }}">{{ $badgeLabel }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Recent Patients --}}
            <div class="card">
                <div class="card-header flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700">{{ __('Recent Patients') }}</h3>
                    <a href="{{ route('patients.index') }}" class="text-xs font-medium text-brand-700 hover:text-brand-800">{{ __('View All') }} &rarr;</a>
                </div>
                @if ($recentPatients->isEmpty())
                    <div class="empty-state">
                        <p class="empty-state-text">{{ __('No patients found.') }}</p>
                        <a href="{{ route('patients.create') }}" class="empty-state-link">{{ __('Add New Patient') }}</a>
                    </div>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach ($recentPatients as $patient)
                            <li class="px-5 py-3 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <a href="{{ route('patients.show', $patient) }}" class="text-sm font-medium text-gray-800 hover:text-brand-700 truncate block">
                                        {{ $patient->name }}
                                        @if ($patient->patient_code)
                                            <span class="inline-block mr-1 bg-gray-100 text-gray-500 text-xs font-mono px-1.5 py-0.5 rounded">{{ $patient->patient_code }}</span>
                                        @endif
                                    </a>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $patient->age ? $patient->age.' '.__('Age') : '—' }}</p>
                                </div>
                                <a href="{{ route('screenings.create', $patient) }}" class="text-xs font-medium text-health-700 hover:text-health-800 whitespace-nowrap">
                                    {{ __('New Screening') }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        {{-- ── High Priority Cases Table ── --}}
        <div class="card">
            <div class="card-header">
                <h3 class="text-sm font-semibold text-gray-700">{{ __('Most Recent High-Priority Cases') }}</h3>
            </div>

            @php
                $statusStyles = [
                    'pending' => 'badge-moderate',
                    'referred' => 'bg-brand-100 text-brand-800 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide',
                    'completed' => 'badge-low',
                ];
            @endphp

            @if ($highPriorityCases->isEmpty())
                <div class="empty-state">
                    <p class="empty-state-text">{{ __('No high-priority cases yet.') }}</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>{{ __('Patient') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Reasons') }}</th>
                                <th>{{ __('Referral Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($highPriorityCases as $case)
                                @php
                                    $referral = $case->referrals->sortByDesc('created_at')->first();
                                @endphp
                                <tr>
                                    <td class="font-medium">
                                        <a href="{{ route('patients.show', $case->screening->patient) }}" class="hover:text-brand-700">
                                            {{ $case->screening->patient->name }}
                                        </a>
                                    </td>
                                    <td class="whitespace-nowrap text-gray-500">{{ $case->screening->created_at->format('M j, Y') }}</td>
                                    <td class="text-gray-600 max-w-xs truncate">{{ $case->reasons }}</td>
                                    <td>
                                        @if ($referral)
                                            <span class="{{ $statusStyles[$referral->status] ?? 'text-xs text-gray-400' }}">
                                                {{ __($referral->status === 'pending' ? 'Pending' : ($referral->status === 'referred' ? 'Referred' : 'Completed')) }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">{{ __('No referral') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
