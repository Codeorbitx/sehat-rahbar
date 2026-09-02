<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-xl border border-gray-100 overflow-hidden">
                @if ($patients->isEmpty())
                    <div class="px-6 py-12 text-center">
                        <p class="text-sm text-gray-500">No patients registered yet.</p>
                        <a href="{{ route('patients.create') }}"
                            class="mt-3 inline-block text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                            Register the first patient
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-50">
                                <tr class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    <th class="px-6 py-3">Name</th>
                                    <th class="px-6 py-3">Age</th>
                                    <th class="px-6 py-3">Gestational Age (weeks)</th>
                                    <th class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($patients as $patient)
                                    <tr class="hover:bg-emerald-50/50 transition cursor-pointer"
                                        onclick="window.location='{{ route('patients.show', $patient) }}'">
                                        <td class="px-6 py-4 font-medium text-gray-800">
                                            <a href="{{ route('patients.show', $patient) }}" class="hover:text-emerald-700">{{ $patient->name }}</a>
                                            @if ($patient->patient_code)
                                                <span class="inline-block ml-2 bg-gray-100 text-gray-600 text-xs font-mono font-medium px-2 py-0.5 rounded-md">{{ $patient->patient_code }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">{{ $patient->age ?? '—' }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $patient->gestational_age_weeks ?? '—' }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('screenings.create', $patient) }}"
                                                onclick="event.stopPropagation()"
                                                class="inline-flex items-center px-3 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold rounded-md transition">
                                                New Screening
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
