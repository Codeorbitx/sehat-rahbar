<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-navy-900">
            {{ __('Screening') }} — {{ $patient->name }}
            @if ($patient->patient_code)
                <span class="inline-block mr-2 bg-gray-100 text-gray-500 text-xs font-mono px-2 py-0.5 rounded-md align-middle">{{ $patient->patient_code }}</span>
            @endif
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="POST" action="{{ route('screenings.store', $patient) }}" class="space-y-8">
            @csrf

            {{-- Section: Vitals --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/></svg>
                        {{ __('Vitals') }}
                    </h3>
                </div>
                <div class="card-body space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">{{ __('BP Systolic') }}</label>
                            <input type="number" name="bp_systolic" value="{{ old('bp_systolic') }}"
                                class="field-input" dir="ltr" placeholder="120">
                        </div>
                        <div>
                            <label class="field-label">{{ __('BP Diastolic') }}</label>
                            <input type="number" name="bp_diastolic" value="{{ old('bp_diastolic') }}"
                                class="field-input" dir="ltr" placeholder="80">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="field-label">{{ __('Blood Sugar') }}</label>
                            <input type="number" step="0.01" name="blood_sugar" value="{{ old('blood_sugar') }}"
                                class="field-input" dir="ltr">
                        </div>
                        <div>
                            <label class="field-label">{{ __('Body Temp') }}</label>
                            <input type="number" step="0.01" name="body_temp" value="{{ old('body_temp') }}"
                                class="field-input" dir="ltr" placeholder="98.6">
                        </div>
                        <div>
                            <label class="field-label">{{ __('Heart Rate') }}</label>
                            <input type="number" name="heart_rate" value="{{ old('heart_rate') }}"
                                class="field-input" dir="ltr" placeholder="72">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section: Symptoms --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.425 48.425 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                        {{ __('Symptoms') }}
                    </h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition">
                            <input type="checkbox" name="swelling" value="1" class="rounded text-brand-600 focus:ring-brand-500 w-5 h-5">
                            <span class="text-sm text-gray-700">{{ __('Swelling') }}</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition">
                            <input type="checkbox" name="severe_headache" value="1" class="rounded text-brand-600 focus:ring-brand-500 w-5 h-5">
                            <span class="text-sm text-gray-700">{{ __('Severe headache') }}</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition">
                            <input type="checkbox" name="vision_issues" value="1" class="rounded text-brand-600 focus:ring-brand-500 w-5 h-5">
                            <span class="text-sm text-gray-700">{{ __('Vision issues') }}</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition">
                            <input type="checkbox" name="low_fetal_movement" value="1" class="rounded text-brand-600 focus:ring-brand-500 w-5 h-5">
                            <span class="text-sm text-gray-700">{{ __('Low fetal movement') }}</span>
                        </label>
                    </div>

                    <div>
                        <label class="field-label">{{ __('Other Symptoms') }}</label>
                        <textarea name="other_symptoms" rows="3"
                            class="field-input" placeholder="{{ __('Other Symptoms') }}"></textarea>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex gap-3">
                <button type="submit" class="btn-primary flex-1 justify-center py-3 text-base">
                    {{ __('Save Screening') }}
                </button>
                <a href="{{ route('patients.show', $patient) }}" class="btn-secondary flex-1 justify-center py-3">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
