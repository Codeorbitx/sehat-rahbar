<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-navy-900">{{ __('New Patient') }}</h2>
    </x-slot>

    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="mb-4 text-sm text-health-700 bg-health-50 border border-health-200 rounded-lg px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('patients.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="field-label">{{ __('Full Name') }} <span class="text-danger-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="field-input" placeholder="{{ __('Full Name') }}">
                        @error('name') <p class="field-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="age" class="field-label">{{ __('Age') }}</label>
                        <input type="number" name="age" id="age" value="{{ old('age') }}"
                            class="field-input" placeholder="{{ __('Age') }}">
                    </div>

                    <div>
                        <label for="gestational_age_weeks" class="field-label">{{ __('Gestational Age (weeks)') }}</label>
                        <input type="number" name="gestational_age_weeks" id="gestational_age_weeks" value="{{ old('gestational_age_weeks') }}"
                            class="field-input" placeholder="{{ __('Gestational Age (weeks)') }}">
                    </div>

                    <div>
                        <label for="contact_number" class="field-label">{{ __('Contact Number') }}</label>
                        <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}"
                            class="field-input" dir="ltr" placeholder="{{ __('Contact Number') }}">
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="btn-success flex-1 justify-center py-2.5">
                            {{ __('Save Patient') }}
                        </button>
                        <a href="{{ route('patients.index') }}" class="btn-secondary flex-1 justify-center py-2.5">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
