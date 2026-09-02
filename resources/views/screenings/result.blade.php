<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4">
        <div class="max-w-md mx-auto">

            @php
                $priority = $screening->triageResult->priority_level;
                $patientCode = $screening->patient->patient_code;
                $actions = [
                    'high' => 'Prompt clinical assessment / referral recommended.',
                    'moderate' => 'Closer monitoring / healthcare assessment recommended.',
                    'low' => 'Routine follow-up recommended.',
                ];
            @endphp

            @if ($priority === 'high')
                <div class="bg-red-50 border-red-300 border-2 rounded-xl p-6 text-center mb-4">
                    <span class="inline-block bg-red-600 text-white text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full mb-3">
                        High Priority
                    </span>
                    <h2 class="text-2xl font-bold text-red-700 mb-1">
                        {{ $screening->patient->name }}
                        @if ($patientCode)
                            <span class="inline-block ml-2 align-middle bg-gray-100 text-gray-600 text-xs font-mono font-medium px-2 py-0.5 rounded-md">{{ $patientCode }}</span>
                        @endif
                    </h2>
                    <p class="text-sm text-gray-500">Screening result</p>
                </div>
            @elseif ($priority === 'moderate')
                <div class="bg-yellow-50 border-yellow-300 border-2 rounded-xl p-6 text-center mb-4">
                    <span class="inline-block bg-yellow-500 text-white text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full mb-3">
                        Moderate Priority
                    </span>
                    <h2 class="text-2xl font-bold text-yellow-700 mb-1">
                        {{ $screening->patient->name }}
                        @if ($patientCode)
                            <span class="inline-block ml-2 align-middle bg-gray-100 text-gray-600 text-xs font-mono font-medium px-2 py-0.5 rounded-md">{{ $patientCode }}</span>
                        @endif
                    </h2>
                    <p class="text-sm text-gray-500">Screening result</p>
                </div>
            @else
                <div class="bg-emerald-50 border-emerald-300 border-2 rounded-xl p-6 text-center mb-4">
                    <span class="inline-block bg-emerald-600 text-white text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full mb-3">
                        Low Priority
                    </span>
                    <h2 class="text-2xl font-bold text-emerald-700 mb-1">
                        {{ $screening->patient->name }}
                        @if ($patientCode)
                            <span class="inline-block ml-2 align-middle bg-gray-100 text-gray-600 text-xs font-mono font-medium px-2 py-0.5 rounded-md">{{ $patientCode }}</span>
                        @endif
                    </h2>
                    <p class="text-sm text-gray-500">Screening result</p>
                </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 mb-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Why this result?</h3>
                <p class="text-sm text-gray-600">{{ $screening->triageResult->reasons }}</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 mb-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Recommended action</h3>
                <p class="text-sm text-gray-600">{{ $actions[$priority] }}</p>
            </div>

            @if ($priority === 'high')
                <a href="{{ route('referrals.create', $screening->patient) }}"
                    class="block w-full text-center py-2 px-4 mb-4 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold rounded-md transition">
                    Create Referral
                </a>
            @endif

            @if ($screening->triageResult->ml_risk_level)
                @php
                    $mlConfidencePct = $screening->triageResult->ml_confidence !== null
                        ? round($screening->triageResult->ml_confidence * 100)
                        : null;
                @endphp
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-1">AI Risk Model (supporting signal)</h3>
                    <p class="text-sm text-gray-600">
                        Predicted risk level: <span class="font-semibold">{{ ucfirst($screening->triageResult->ml_risk_level) }}</span>
                        @if ($mlConfidencePct !== null)
                            <span class="mx-1 text-gray-300">&middot;</span>Confidence: <span class="font-semibold">{{ $mlConfidencePct }}%</span>
                        @endif
                    </p>
                    <p class="mt-2 text-xs text-gray-400">
                        This is a supporting signal from a machine learning model trained on clinical data, alongside our rule-based clinical triage engine above.
                    </p>
                </div>
            @endif

            <p class="text-xs text-gray-400 text-center mb-4">
                This is a decision-support tool, not a diagnosis. Clinical judgment should always guide final decisions.
            </p>

            <a href="{{ route('patients.create') }}"
                class="block w-full text-center py-2 px-4 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold rounded-md transition">
                Register Another Patient
            </a>
        </div>
    </div>
</x-app-layout>