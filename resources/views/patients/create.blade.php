<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 flex justify-center">
        <div class="w-full max-w-md mx-4 bg-white shadow-md rounded-xl border border-gray-100 overflow-hidden">
            <div class="flex flex-col items-center pt-6 pb-2">
                <img src="{{ asset('images/logo.png') }}" alt="Sehat Rahbar" class="w-12 h-auto object-contain">
                <h2 class="mt-2 text-lg font-medium text-gray-800">New Patient</h2>
            </div>

            <div class="px-6 pb-6">
                @if (session('success'))
                    <div class="mb-4 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md px-3 py-2">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('patients.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                        @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                        <input type="number" name="age" id="age"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label for="gestational_age_weeks" class="block text-sm font-medium text-gray-700">Gestational Age (weeks)</label>
                        <input type="number" name="gestational_age_weeks" id="gestational_age_weeks"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                    </div>

                    <button type="submit"
                        class="w-full inline-flex justify-center py-2 px-4 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold rounded-md transition">
                        Register Patient
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>