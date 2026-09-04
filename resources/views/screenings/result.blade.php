<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        @php
            $priority = $screening->triageResult->priority_level;
            $patientCode = $screening->patient->patient_code;

            $statusConfig = [
                'high' => [
                    'border' => 'border-danger-300 border-2',
                    'bg' => 'bg-danger-50',
                    'badge' => 'badge-high',
                    'label' => __('High Priority'),
                    'heading' => 'text-danger-700',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>',
                    'recommendation' => __('Prompt clinical assessment / referral recommended.'),
                ],
                'moderate' => [
                    'border' => 'border-warn-300 border-2',
                    'bg' => 'bg-warn-50',
                    'badge' => 'badge-moderate',
                    'label' => __('Moderate Priority'),
                    'heading' => 'text-warn-700',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>',
                    'recommendation' => __('Closer monitoring / healthcare assessment recommended.'),
                ],
                'low' => [
                    'border' => 'border-health-300 border-2',
                    'bg' => 'bg-health-50',
                    'badge' => 'badge-low',
                    'label' => __('Low Priority'),
                    'heading' => 'text-health-700',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    'recommendation' => __('Routine follow-up recommended.'),
                ],
            ];
            $config = $statusConfig[$priority] ?? $statusConfig['low'];
        @endphp

        {{-- ── Result Banner ── --}}
        <div class="{{ $config['bg'] }} {{ $config['border'] }} rounded-2xl p-6 sm:p-8 text-center">
            <svg class="w-12 h-12 mx-auto {{ $config['heading'] }} mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                {!! $config['icon'] !!}
            </svg>
            <span class="{{ $config['badge'] }} text-sm">{{ $config['label'] }}</span>
            <h2 class="mt-3 text-2xl font-bold {{ $config['heading'] }}">
                {{ __('Screening Result') }}
            </h2>
            <p class="mt-2 text-base font-semibold text-gray-800">
                {{ $screening->patient->name }}
                @if ($patientCode)
                    <span class="inline-block mr-2 bg-white/60 text-gray-600 text-xs font-mono px-2 py-0.5 rounded-md align-middle">{{ $patientCode }}</span>
                @endif
            </p>
            <p class="text-sm text-gray-500 mt-1">{{ $screening->created_at->format('M j, Y, g:i A') }}</p>
        </div>

        {{-- ── Why this result ── --}}
        <div class="card">
            <div class="card-header flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                <h3 class="text-sm font-semibold text-gray-700">{{ __('Why this result?') }}</h3>
            </div>
            <div class="card-body">
                <p class="text-sm text-gray-600 leading-relaxed">{{ $screening->triageResult->reasons }}</p>
            </div>
        </div>

        {{-- ── Recommended action ── --}}
        <div class="card">
            <div class="card-header flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                <h3 class="text-sm font-semibold text-gray-700">{{ __('Next steps for you') }}</h3>
            </div>
            <div class="card-body">
                <p class="text-sm text-gray-600 leading-relaxed">{{ $config['recommendation'] }}</p>
            </div>
        </div>

        {{-- ── Referral CTA for high priority ── --}}
        @if ($priority === 'high')
            <a href="{{ route('referrals.create', $screening->patient) }}"
                class="btn-danger w-full justify-center py-3 text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                {{ __('Create Referral') }}
            </a>
        @endif

        {{-- ── ML Prediction (if available) ── --}}
        @if ($screening->triageResult->ml_risk_level)
            @php
                $mlConfidencePct = $screening->triageResult->ml_confidence !== null
                    ? round($screening->triageResult->ml_confidence * 100)
                    : null;
            @endphp
            <div class="card border-brand-200">
                <div class="card-header flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/></svg>
                    <h3 class="text-sm font-semibold text-gray-700">{{ __('AI Risk Model (supporting signal)') }}</h3>
                </div>
                <div class="card-body">
                    <p class="text-sm text-gray-600">
                        {{ __('Predicted risk level:') }} <span class="font-bold">{{ ucfirst($screening->triageResult->ml_risk_level) }}</span>
                        @if ($mlConfidencePct !== null)
                            <span class="mx-2 text-gray-300">|</span>
                            {{ __('Confidence:') }} <span class="font-bold">{{ $mlConfidencePct }}%</span>
                        @endif
                    </p>
                    <p class="mt-2 text-xs text-gray-400 leading-relaxed">
                        {{ __('This is a supporting signal from a machine learning model trained on clinical data, alongside our rule-based clinical triage engine above.') }}
                    </p>
                </div>
            </div>
        @endif

        {{-- ── Disclaimer ── --}}
        <p class="text-xs text-gray-400 text-center leading-relaxed">
            {{ __('This is a decision-support tool, not a diagnosis. Clinical judgment should always guide final decisions.') }}
        </p>

        {{-- ── Action buttons ── --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('patients.show', $screening->patient) }}" class="btn-secondary flex-1 justify-center py-2.5">
                {{ __('Go to Patient History') }}
            </a>
            <a href="{{ route('patients.create') }}" class="btn-success flex-1 justify-center py-2.5">
                {{ __('Register Another Patient') }}
            </a>
        </div>

    </div>
</x-app-layout>
