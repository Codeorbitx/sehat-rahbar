<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-navy-900">
            {{ __('Referral') }} — {{ $patient->name }}
            @if ($patient->patient_code)
                <span class="inline-block mr-2 bg-gray-100 text-gray-500 text-xs font-mono px-2 py-0.5 rounded-md align-middle">{{ $patient->patient_code }}</span>
            @endif
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('referrals.store', $patient) }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="facility_name" class="field-label">{{ __('Facility Name') }} <span class="text-danger-500">*</span></label>
                        <input type="text" name="facility_name" id="facility_name" value="{{ old('facility_name') }}" required
                            class="field-input" placeholder="{{ __('Facility Name') }}">
                        @error('facility_name') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="referral_date" class="field-label">{{ __('Referral Date') }}</label>
                        <input type="date" name="referral_date" id="referral_date" value="{{ old('referral_date', now()->toDateString()) }}"
                            class="field-input" dir="ltr">
                        @error('referral_date') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="btn-success flex-1 justify-center py-2.5">
                            {{ __('Save Referral') }}
                        </button>
                        <a href="{{ route('patients.show', $patient) }}" class="btn-secondary flex-1 justify-center py-2.5">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
