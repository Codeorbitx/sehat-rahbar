<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="text-xl font-bold text-navy-900">{{ __('Patients') }}</h2>
            <a href="{{ route('patients.create') }}" class="btn-success text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                {{ __('Add New Patient') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="card">
            @if ($patients->isEmpty())
                <div class="empty-state">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                    <p class="empty-state-text">{{ __('No patients found.') }}</p>
                    <a href="{{ route('patients.create') }}" class="empty-state-link">{{ __('Add New Patient') }}</a>
                </div>
            @else
                {{-- Desktop table --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Age') }}</th>
                                <th>{{ __('Contact Number') }}</th>
                                <th>{{ __('Last Screening') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $patient)
                                @php
                                    $lastScreening = $patient->screenings->first();
                                    $priority = $lastScreening?->triageResult?->priority_level ?? null;
                                    $badgeClass = $priority === 'high' ? 'badge-high' : ($priority === 'moderate' ? 'badge-moderate' : ($priority === 'low' ? 'badge-low' : ''));
                                    $badgeLabel = $priority === 'high' ? __('High Priority') : ($priority === 'moderate' ? __('Moderate Priority') : ($priority === 'low' ? __('Low Priority') : '—'));
                                @endphp
                                <tr>
                                    <td class="font-medium">
                                        <a href="{{ route('patients.show', $patient) }}" class="hover:text-brand-700">
                                            {{ $patient->name }}
                                        </a>
                                        @if ($patient->patient_code)
                                            <span class="inline-block mr-2 bg-gray-100 text-gray-500 text-xs font-mono px-1.5 py-0.5 rounded">{{ $patient->patient_code }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $patient->age ?? '—' }}</td>
                                    <td dir="ltr" class="text-start">{{ $patient->contact_number ?? '—' }}</td>
                                    <td>
                                        @if ($priority)
                                            <span class="{{ $badgeClass }}">{{ $badgeLabel }}</span>
                                        @else
                                            <span class="text-xs text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('patients.show', $patient) }}" class="text-xs font-medium text-brand-700 hover:text-brand-800">{{ __('View') }}</a>
                                            <a href="{{ route('screenings.create', $patient) }}" class="btn-success text-xs px-3 py-1">{{ __('New Screening') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile cards --}}
                <div class="sm:hidden divide-y divide-gray-100">
                    @foreach ($patients as $patient)
                        @php
                            $lastScreening = $patient->screenings->first();
                            $priority = $lastScreening?->triageResult?->priority_level ?? null;
                            $badgeClass = $priority === 'high' ? 'badge-high' : ($priority === 'moderate' ? 'badge-moderate' : ($priority === 'low' ? 'badge-low' : ''));
                            $badgeLabel = $priority === 'high' ? __('High Priority') : ($priority === 'moderate' ? __('Moderate Priority') : ($priority === 'low' ? __('Low Priority') : '—'));
                        @endphp
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <a href="{{ route('patients.show', $patient) }}" class="text-sm font-semibold text-gray-800 hover:text-brand-700 block truncate">
                                        {{ $patient->name }}
                                    </a>
                                    @if ($patient->patient_code)
                                        <span class="inline-block mt-0.5 bg-gray-100 text-gray-500 text-xs font-mono px-1.5 py-0.5 rounded">{{ $patient->patient_code }}</span>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1">{{ $patient->age ? $patient->age.' '.__('Age') : '' }}</p>
                                </div>
                                @if ($priority)
                                    <span class="{{ $badgeClass }}">{{ $badgeLabel }}</span>
                                @endif
                            </div>
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('patients.show', $patient) }}" class="btn-secondary text-xs px-3 py-1.5 flex-1 text-center">{{ __('View') }}</a>
                                <a href="{{ route('screenings.create', $patient) }}" class="btn-success text-xs px-3 py-1.5 flex-1 text-center">{{ __('New Screening') }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
