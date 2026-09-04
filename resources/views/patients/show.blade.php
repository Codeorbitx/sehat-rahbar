<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="text-xl font-bold text-navy-900">{{ __('Patient History') }}</h2>
            <a href="{{ route('screenings.create', $patient) }}" class="btn-success text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                {{ __('New Screening') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        @php
            $badges = [
                'high' => ['class' => 'badge-high', 'label' => __('High Priority')],
                'moderate' => ['class' => 'badge-moderate', 'label' => __('Moderate Priority')],
                'low' => ['class' => 'badge-low', 'label' => __('Low Priority')],
            ];
            $statusStyles = [
                'pending' => 'badge-moderate',
                'referred' => 'bg-brand-100 text-brand-800 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide',
                'completed' => 'badge-low',
            ];
        @endphp

        @if (session('success'))
            <div class="text-sm text-health-700 bg-health-50 border border-health-200 rounded-lg px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="text-sm text-danger-700 bg-danger-50 border border-danger-200 rounded-lg px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        {{-- Patient info card --}}
        <div class="card">
            <div class="card-body flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-navy-900">
                        {{ $patient->name }}
                        @if ($patient->patient_code)
                            <span class="inline-block mr-2 bg-gray-100 text-gray-500 text-xs font-mono px-2 py-0.5 rounded-md align-middle">{{ $patient->patient_code }}</span>
                        @endif
                    </h3>
                    <div class="mt-2 flex flex-wrap gap-x-6 gap-y-1 text-sm text-gray-500">
                        <p><span class="font-medium text-gray-700">{{ __('Age') }}:</span> {{ $patient->age ?? '—' }}</p>
                        <p><span class="font-medium text-gray-700">{{ __('Gestational Age') }}:</span> {{ $patient->gestational_age_weeks ? $patient->gestational_age_weeks.' '.__('weeks') : '—' }}</p>
                        <p><span class="font-medium text-gray-700">{{ __('Contact Number') }}:</span> <span dir="ltr">{{ $patient->contact_number ?? '—' }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Referrals --}}
        @if ($patient->referrals->isNotEmpty())
            <div class="card">
                <div class="card-header">
                    <h3 class="text-sm font-semibold text-gray-700">{{ __('Referrals') }}</h3>
                </div>
                <ul class="divide-y divide-gray-100">
                    @foreach ($patient->referrals as $referral)
                        <li class="px-5 py-4 flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $referral->facility_name }}</p>
                                <p class="mt-0.5 text-xs text-gray-400">{{ $referral->referral_date?->format('M j, Y') ?? '—' }}</p>
                            </div>
                            <span class="{{ $statusStyles[$referral->status] ?? 'text-xs text-gray-400' }}">
                                {{ __($referral->status === 'pending' ? 'Pending' : ($referral->status === 'referred' ? 'Referred' : 'Completed')) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Screening history timeline --}}
        <div class="card">
            <div class="card-header">
                <h3 class="text-sm font-semibold text-gray-700">{{ __('Screening History') }}</h3>
            </div>

            @if ($patient->screenings->isEmpty())
                <div class="empty-state">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.425 48.425 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
                    </svg>
                    <p class="empty-state-text">{{ __('No screening history available.') }}</p>
                    <a href="{{ route('screenings.create', $patient) }}" class="empty-state-link">{{ __('Start the first screening') }}</a>
                </div>
            @else
                <ol class="relative border-s-2 border-gray-200 ms-6 py-6 pe-6 space-y-8">
                    @foreach ($patient->screenings as $screening)
                        @php
                            $priority = $screening->triageResult->priority_level ?? null;
                            $badge = $badges[$priority] ?? ['class' => 'text-xs text-gray-400', 'label' => __('Result pending.')];
                        @endphp
                        <li class="relative ps-6">
                            <span class="absolute -start-[9px] top-1 h-4 w-4 rounded-full ring-4 ring-white
                                {{ $priority === 'high' ? 'bg-danger-500' : ($priority === 'moderate' ? 'bg-warn-400' : ($priority === 'low' ? 'bg-health-500' : 'bg-gray-300')) }}"></span>
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="text-sm font-semibold text-gray-800">{{ $screening->created_at->format('M j, Y, g:i A') }}</span>
                                @if ($priority)
                                    <span class="{{ $badge['class'] }}">{{ $badge['label'] }}</span>
                                @endif
                                <a href="{{ route('screenings.result', $screening) }}" class="text-xs font-medium text-brand-700 hover:text-brand-800">
                                    {{ __('View') }} &rarr;
                                </a>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">{{ $screening->triageResult->reasons ?? __('Result pending.') }}</p>
                        </li>
                    @endforeach
                </ol>
            @endif
        </div>

    </div>
</x-app-layout>
