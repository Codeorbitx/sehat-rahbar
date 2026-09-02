<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 flex justify-center">
        <div class="w-full max-w-md mx-4 bg-white shadow-md rounded-xl border border-gray-100 overflow-hidden">
            <div class="flex flex-col items-center pt-6 pb-2">
                <img src="{{ asset('images/logo.png') }}" alt="Sehat Rahbar" class="w-12 h-auto object-contain">
                <h2 class="mt-2 text-lg font-medium text-gray-800">Referral — {{ $patient->name }}</h2>
            </div>

            <div class="px-6 pb-6">
                <form method="POST" action="{{ route('referrals.store', $patient) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="facility_name" class="block text-sm font-medium text-gray-700">Facility Name</label>
                        <input type="text" name="facility_name" id="facility_name" value="{{ old('facility_name') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        @error('facility_name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="referral_date" class="block text-sm font-medium text-gray-700">Referral Date</label>
                        <input type="date" name="referral_date" id="referral_date" value="{{ old('referral_date', now()->toDateString()) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        @error('referral_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                        class="w-full inline-flex justify-center py-2 px-4 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold rounded-md transition">
                        Save Referral
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
