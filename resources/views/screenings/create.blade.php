<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 flex justify-center">
        <div class="w-full max-w-md mx-4 bg-white shadow-md rounded-xl border border-gray-100 overflow-hidden">
            <div class="flex flex-col items-center pt-6 pb-2">
                <img src="{{ asset('images/logo.png') }}" alt="Sehat Rahbar" class="w-12 h-auto object-contain">
                <h2 class="mt-2 text-lg font-medium text-gray-800">Screening — {{ $patient->name }}</h2>
            </div>

            <div class="px-6 pb-6">
                <form method="POST" action="{{ route('screenings.store', $patient) }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">BP Systolic</label>
                            <input type="number" name="bp_systolic"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">BP Diastolic</label>
                            <input type="number" name="bp_diastolic"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Blood Sugar</label>
                            <input type="number" step="0.01" name="blood_sugar"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Body Temp</label>
                            <input type="number" step="0.01" name="body_temp"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Heart Rate</label>
                            <input type="number" name="heart_rate"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        </div>
                    </div>

                    <div class="space-y-2 pt-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="swelling" value="1" class="rounded text-emerald-600 focus:ring-emerald-600">
                            <span class="text-sm text-gray-700">Swelling</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="severe_headache" value="1" class="rounded text-emerald-600 focus:ring-emerald-600">
                            <span class="text-sm text-gray-700">Severe headache</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="vision_issues" value="1" class="rounded text-emerald-600 focus:ring-emerald-600">
                            <span class="text-sm text-gray-700">Vision issues</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="low_fetal_movement" value="1" class="rounded text-emerald-600 focus:ring-emerald-600">
                            <span class="text-sm text-gray-700">Low fetal movement</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Other Symptoms</label>
                        <textarea name="other_symptoms" rows="2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full inline-flex justify-center py-2 px-4 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold rounded-md transition">
                        Save Screening
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>